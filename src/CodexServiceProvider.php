<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex;


use Codex\Documents\Document;
use Codex\Http\Controllers\CodexController;
use Codex\Log\Writer;
use Codex\Menus\ProjectsMenuResolver;
use Codex\Menus\RefsMenuResolver;
use Codex\Menus\SidebarMenuResolver;
use Codex\Support\Traits\CodexProviderTrait;
use Illuminate\Contracts\Foundation\Application as LaravelApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Filesystem\FilesystemAdapter;
use Laradic\ServiceProvider\ServiceProvider;
use League\Flysystem\Filesystem as Flysystem;
use Monolog\Logger as Monolog;


/**
 * This is the class CodexServiceProvider.
 *
 * @package        Codex\Core
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 *
 */
class CodexServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $dir = __DIR__;

    protected $configFiles = [ 'codex' ];

    protected $viewDirs = [
        'views' => 'codex',
        'stubs' => 'codex-stubs',
    ];

    protected $assetDirs = [
        'assets'     => 'codex',
        'dev/assets' => 'codex-dev',
    ];

    protected $providers = [
        \Radic\BladeExtensions\BladeExtensionsServiceProvider::class,
    ];

    protected $findCommands = [ 'Console' ];

    protected $bindings = [
        'fs'                      => \Laradic\Filesystem\Filesystem::class,
        'codex.menus'             => Menus\Menus::class,
        'codex.menu'              => Menus\Menu::class,
        'codex.projects'          => Projects\Projects::class,
        'codex.project'           => Projects\Project::class,
        'codex.refs'              => Projects\Refs::class,
        'codex.ref'               => Projects\Ref::class,
        'codex.documents'         => Documents\Documents::class,
        'codex.document'          => Documents\Document::class,
        'codex.project.generator' => Projects\ProjectGenerator::class,
        'codex.theme'             => Theme::class,
    ];

    protected $singletons = [
        'codex.addons' => Addons\Addons::class,
    ];

    protected $shared = [
        'codex' => Codex::class,
    ];

    protected $aliases = [
        'codex.log' => Contracts\Log\Log::class,
    ];

    /** @var Addons\Addons */
    protected $addons;

    public function boot()
    {
        $app = parent::boot();

        $this->bootBladeDirectives();

        return $app;
    }

    public function booting()
    {
        $codex = $this->codex();

        # Menus

        # Plugins
        $this->addons->plugins->run();

        $codex->menus->add('sidebar')
            ->setResolver(SidebarMenuResolver::class)
            ->setView($codex->view('menus.sidebar'));

        $codex->menus->add('projects')
            ->setResolver(ProjectsMenuResolver::class)
            ->setView($codex->view('menus.header'));

        $codex->menus->add('refs')
            ->setResolver(RefsMenuResolver::class)
            ->setView($codex->view('menus.header'));

        $this->codexHook('controller:document', function ($controller, Document $document, Codex $codex, $project, $ref) {
            $codex->theme->pushContentToStack('nav', $codex->view('document'), function ($view) use ($codex, $document) {
                return $codex->menus->get('refs')->render($document->getRef());
            });
            $codex->theme->pushContentToStack('nav', $codex->view('document'), function ($view) use ($codex, $document) {
                return $codex->menus->get('projects')->render($document->getProject());
            });
        });
    }


    public function register()
    {
        $app = parent::register();

        $config = $this->app->make('config');

        if ( $config->get('codex.log', false) ) {
            $this->registerLogger();
        }

        $this->registerDefaultFilesystem();

        $this->registerCodex();

        $this->registerAddons();

        $this->registerJavascriptData();

        if ( $config->get('codex.http.enabled', false) ) {
            $this->registerHttp();
        }

        return $app;
    }

    /**
     * registerLogger method
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return \Codex\Log\Writer
     */
    protected function registerLogger()
    {
        $this->app->instance('codex.log', $log = new Writer(
            new Monolog($this->app->environment()),
            $this->app[ 'events' ]
        ));
        $log->useFiles($this->app[ 'config' ][ 'codex.paths.log' ]);
        $log->useChromePHP();
        $log->useFirePHP();
        return $log;
    }

    protected function registerCodex()
    {
        Codex::registerExtension('codex', 'menus', 'codex.menus');
        Codex::registerExtension('codex', 'theme', 'codex.theme');
        Codex::registerExtension('codex', 'projects', 'codex.projects');
        Codex::registerExtension('codex.project', 'refs', 'codex.refs');
        Codex::registerExtension('codex.ref', 'documents', 'codex.documents');
    }

    protected function registerDefaultFilesystem()
    {
        $this->app->make('filesystem')->extend('codex-local', function (LaravelApplication $app, array $config = []) {
            $flysystemAdapter    = new Filesystem\Local($config[ 'root' ]);
            $flysystemFilesystem = new Flysystem($flysystemAdapter);
            return new FilesystemAdapter($flysystemFilesystem);
        });
    }

    protected function registerHttp()
    {
        $this->app->register(Http\HttpServiceProvider::class);
    }

    protected function bootBladeDirectives()
    {
        /** @var \Illuminate\View\Compilers\BladeCompiler $blade */
        $blade = $this->app[ 'view' ]->getEngineResolver()->resolve('blade')->getCompiler();
        //Register the Starting Tag
        $blade->directive('spaceless', function () {
            return '<?php ob_start() ?>';
        });
        //Register the Ending Tag
        $blade->directive('endspaceless', function () {
            return "<?php echo preg_replace('/>\\s+</', '><', ob_get_clean()); ?>";
        });
    }

    protected function registerJavascriptData()
    {
        $this->codexHook('controller:view', function (CodexController $controller, $view, Codex $codex, Projects\Project $project, Documents\Document $document) {
            /** @var Codex $codex */
            $theme = $codex->theme;
            $theme->set('codex', $c = $codex->config()->only('display_name', 'macros', 'links', 'document', 'default_project')->toArray());
            $theme->set('project', [
                'name'         => $project->getName(),
                'display_name' => $project->getDisplayName(),
            ]);
            $theme->set('document', $document->toArray());
            $theme->set('theme', $theme->toArray());
            $theme->set('apiUrl', url('api'));
            $theme->set('debug', config('app.debug', false));
        });
    }

    protected function registerAddons()
    {
        $this->app->instance('codex.addons', $this->addons = Addons\Addons::getInstance());
        $this->addons->setManifestPath($this->app[ 'config' ][ 'codex.paths.manifest' ]);
        $this->addons->resolveAndRegisterDirectory(__DIR__ . '/Processors');
        $this->addons->resolveAndRegisterAddons();
    }


}
