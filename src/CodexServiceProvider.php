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
use Codex\Projects\Project;
use Codex\Traits\CodexProviderTrait;
use Illuminate\Contracts\Foundation\Application as LaravelApplication;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem as Flysystem;
use Monolog\Logger as Monolog;
use Sebwite\Support\ServiceProvider;

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
        \Radic\BladeExtensions\BladeExtensionsServiceProvider::class
    ];

    protected $commands = [
        Console\ListCommand::class,
        Console\CreateCommand::class,
    ];

    protected $bindings = [
        'fs'                      => \Sebwite\Filesystem\Filesystem::class,
        'codex.document'          => Documents\Document::class,
        'codex.menu'              => Menus\Menu::class,
        'codex.project'           => Projects\Project::class,
        'codex.project.generator' => Projects\ProjectGenerator::class,
    ];

    protected $singletons = [
       # 'codex'        => Codex::class,
        'codex.addons' => Addons\Factory::class,
    ];

    protected $shared = [
        'codex' => Codex::class
    ];

    protected $aliases = [
        'codex.log' => Contracts\Log\Log::class,
        #'codex'     => Contracts\Codex::class,
    ];

    /** @var Addons\Factory */
    protected $addons;

    public function boot()
    {
        $app = parent::boot();

        #$this->bootAttributesProcessor();

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

        $this->registerTheme();

        $this->registerJavascriptData();

        if ( $this->app[ 'config' ][ 'codex.http.enabled' ] === true )
        {
            $this->registerRouting();
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
        $this->codexHook('constructed', function (Contracts\Codex $codex)
        {
            $codex->extend('projects', Projects\Projects::class);
            $codex->extend('menus', Menus\Menus::class);

            $codex->extend('theme', Helpers\ThemeHelper::class);
            $codex->extend('cache', Helpers\CacheHelper::class);

        });

        #$this->share('codex', Codex::class, [ ], true);
        #$this->app->alias('codex', Contracts\Codex::class);

        $this->codexHook('project:construct', function (Project $project)
        {
            $project->extend('documents', Documents\Documents::class);
        });
    }

    protected function registerDefaultFilesystem()
    {
        $this->app->make('filesystem')->extend('codex-local', function (LaravelApplication $app, array $config = [ ])
        {
            $flysystemAdapter    = new Filesystem\Local($config[ 'root' ]);
            $flysystemFilesystem = new Flysystem($flysystemAdapter);
            return new FilesystemAdapter($flysystemFilesystem);
        });
    }

    protected function registerDev()
    {
        $this->app->register(Dev\DevServiceProvider::class);
    }

    protected function registerRouting()
    {
        $this->app->register(Http\HttpServiceProvider::class);
    }

    protected function registerTheme()
    {
        $this->codexHook('constructed', function (Contracts\Codex $codex)
        {
            /** @var \Codex\Codex|\Codex\Contracts\Codex $codex */
            $codex->theme->addStylesheet('vendor', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css', [ ], true);
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
        $blade->directive('spaceless', function ()
        {
            return '<?php ob_start() ?>';
        });
        //Register the Ending Tag
        $blade->directive('endspaceless', function ()
        {
            return "<?php echo preg_replace('/>\\s+</', '><', ob_get_clean()); ?>";
        });
    }

    protected function registerJavascriptData()
    {
        $this->codexHook('controller:view', function (CodexController $controller, $view, Contracts\Codex $codex, Project $project, Documents\Document $document)
        {
            /** @var Codex $codex */
            $theme = $codex->theme;
            $theme->set('codex', $c = $codex->config()->only('display_name', 'doctags', 'document', 'default_project')->toArray());
            $theme->set('project', $project->getName());
            $theme->set('display_name', $project->getDisplayName());
            $theme->set('document', $document->getName());
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

    protected function bootAttributesProcessor()
    {
        // Individually run the attributes processor first.
        // This way we get the document attributes filled and disable, enable or configure other processors.
        $this->codexHook('document:constructed', function (Document $document)
        {
            $document->runProcessor('attributes');
        });
    }

}
