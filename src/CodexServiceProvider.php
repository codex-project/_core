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
use Codex\Menus\SidebarMenuResolver;
use Codex\Support\Traits\CodexProviderTrait;
use Illuminate\Contracts\Foundation\Application as LaravelApplication;
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
        'fs'          => \Laradic\Filesystem\Filesystem::class,
        'codex.menus' => Menus\Menus::class,
        'codex.menu'  => Menus\Menu::class,

        'codex.projects'  => Projects\Projects::class,
        'codex.project'   => Projects\Project::class,
        'codex.refs'      => Projects\Refs::class,
        'codex.ref'       => Projects\Ref::class,
        'codex.documents' => Documents\Documents::class,
        'codex.document'  => Documents\Document::class,

        'codex.project.generator' => Projects\ProjectGenerator::class,
        'codex.helpers.theme'     => Helpers\ThemeHelper::class,
        'codex.helpers.cache'     => Helpers\CacheHelper::class,
    ];

    protected $singletons = [
        'codex.addons' => Addons\Factory::class,
    ];

    protected $shared = [
        'codex' => Codex::class,
    ];

    protected $aliases = [
        'codex.log' => Contracts\Log\Log::class,
    ];

    /** @var Addons\Factory */
    protected $addons;

    public function boot()
    {
        $app = parent::boot();

        $this->bootBladeDirectives();

        return $app;
    }

    public function register()
    {
        $app = parent::register();

        $this->registerDev();

        $this->registerLogger();

        $this->registerDefaultFilesystem();

        $this->registerCodex();

        $this->registerAddons();

        $this->registerMenus();

        $this->registerTheme();

        $this->registerJavascriptData();

        if ( $this->app[ 'config' ]->get('codex.http.enabled', false) ) {
            $this->registerHttp();
        }

        // After all providers are registered, we also run the plugins, so they are also registered before booting providers.
        $app->booting(function ($app) {
            $this->addons->plugins->run();
        });

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
        $this->app->resolving('codex', function(){
            $a = func_get_args();

            $as = 'a';
        });
        #Codex::extend('codex', 'menus', 'codex.menus');
        Codex::extend('menus', 'codex.menus');
        Codex::extend('theme', 'codex.helpers.theme');
        Codex::extend('cache', 'codex.helpers.cache');
        Codex::extend('projects', 'codex.projects');

        Projects\Project::extend('refs', 'codex.refs');

        Projects\Ref::extend('documents', 'codex.documents');
    }

    protected function registerDefaultFilesystem()
    {
        $this->app->make('filesystem')->extend('codex-local', function (LaravelApplication $app, array $config = []) {
            $flysystemAdapter    = new Filesystem\Local($config[ 'root' ]);
            $flysystemFilesystem = new Flysystem($flysystemAdapter);
            return new FilesystemAdapter($flysystemFilesystem);
        });
    }

    protected function registerDev()
    {
        $this->app->register(Dev\DevServiceProvider::class);
    }

    protected function registerHttp()
    {
        $this->app->register(Http\HttpServiceProvider::class);
    }

    protected function registerTheme()
    {
        $this->codexHook('constructed', function (Codex $codex) {
            /** @var \Codex\Codex $codex */
            $codex->theme->addStylesheet('vendor', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css', [], true);
            $codex->theme->addStylesheet('theme', 'vendor/codex/styles/stylesheet', [ 'vendor' ]);
            $codex->theme->addStylesheet('prism', 'vendor/codex/styles/prism', [ 'theme' ]);
            $codex->theme
                ->addJavascript('vendor', 'vendor/codex/scripts/vendor')
                ->addJavascript('codex', 'vendor/codex/scripts/codex', [ 'vendor' ])
                ->addJavascript('theme', 'vendor/codex/scripts/theme', [ 'codex' ]);
            $codex->theme->addBodyClass('docs language-php');
            $codex->theme->addScript('codex', 'codex.init();');
            $codex->theme->addScript('theme', 'codex.theme.init();', [ 'codex' ]);
        });
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
        $this->app->instance('codex.addons', $this->addons = Addons\Factory::getInstance());
        $this->addons->setManifestPath($this->app[ 'config' ][ 'codex.paths.manifest' ]);
        $this->addons->scanAndResolveDirectory(__DIR__ . '/Processors');
        $this->addons->scanAndResolveAddonPackages();
    }

    protected function registerMenus()
    {


        $this->codexHook('constructed', function (Codex $codex) {
            $codex->menus->add('sidebar')->setResolver(SidebarMenuResolver::class);
        });

        $this->codexHook('controller:view', function () {
            $projectsMenu = $this->codex()->menus->add('projects')->setResolver(ProjectsMenuResolver::class);
            $this->codex()->theme->pushContentToStack('nav', $this->codexView('layout'), function ($view) use ($projectsMenu) {
                return $projectsMenu->render();
            });
        });
    }

}
