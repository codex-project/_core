<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex;

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

    protected $viewDirs = [ 'views' => 'codex' ];

    protected $assetDirs = [
        'assets'     => 'codex',
        'dev/assets' => 'codex-dev',
    ];

    protected $providers = [
        \Radic\BladeExtensions\BladeExtensionsServiceProvider::class,
    ];

    protected $commands = [
        Console\ListCommand::class,
        Console\CreateCommand::class,
    ];

    protected $bindings = [
        'codex.document' => Documents\Document::class,
        'codex.project'  => Projects\Project::class,
        'codex.menu'     => Menus\Menu::class,
    ];

    protected $singletons = [
        'codex.addons' => Addons\Addons::class,
        'codex'        => Codex::class,
    ];

    protected $aliases = [
        'codex.log' => Contracts\Log::class,
        'codex'     => Contracts\Codex::class,
    ];

    protected $weaklings = [
        'fs' => \Sebwite\Filesystem\Filesystem::class,
    ];

    /** @var Addons\Addons */
    protected $addons;

    public function boot()
    {
        $app = parent::boot();
        $this->bootBladeDirectives();
        $this->addons->registerInPath(__DIR__ . '/Addons/Filters');
        $this->addons->findAndRegisterAll();
        return $app;
    }

    public function register()
    {
        $app = parent::register();


        $this->registerDefaultFilesystem();

        $this->registerCodex();

        $this->app->instance('codex.addons', $this->addons = Addons\Addons::getInstance());

        $this->registerTheme();

        $log = $this->registerLogger();

        $log->info('init');

        if ( $this->app[ 'config' ][ 'codex.routing.enabled' ] === true )
        {
            $this->registerRouting();
        }

        if ( $this->app[ 'config' ][ 'codex.dev.enabled' ] === true )
        {
            $this->app->register(Dev\DevServiceProvider::class);
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
        $log->useFiles($this->app[ 'config' ][ 'codex.log.path' ]);

        return $log;
    }

    protected function registerCodex()
    {

        $this->codexHook('constructed', function (Contracts\Codex $codex)
        {
            $codex->extend('projects', Projects\Projects::class);
            $codex->extend('menus', Menus\Menus::class);
            $codex->extend('theme', Theme::class);
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
            $codex->theme
                ->addJavascript('vendor', 'vendor/codex/scripts/vendor')
                ->addJavascript('codex', 'vendor/codex/scripts/codex', [ 'vendor' ])
                ->addJavascript('theme', 'vendor/codex/scripts/theme', [ 'codex' ]);
            $codex->theme->addBodyClass('docs language-php');
            $codex->theme->addScript('codex', 'codex.init();');
            $codex->theme->addScript('theme', 'codex.theme.init();', ['codex']);
        });
    }

    protected function bootBladeDirectives()
    {
        //Register the Starting Tag
        \Blade::directive('spaceless', function ()
        {
            return '<?php ob_start() ?>';
        });
        //Register the Ending Tag
        \Blade::directive('endspaceless', function ()
        {
            return "<?php echo preg_replace('/>\\s+</', '><', ob_get_clean()); ?>";
        });
    }

}
