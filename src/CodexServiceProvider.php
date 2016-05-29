<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core;

use Codex\Core\Log\Writer;
use Codex\Core\Projects\Project;
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
    protected $dir = __DIR__;

    protected $configFiles = [ 'codex' ];

    protected $viewDirs = [ 'views' => 'codex' ];

    protected $assetDirs = [ 'assets' => 'codex' ];

    protected $providers = [
        \Radic\BladeExtensions\BladeExtensionsServiceProvider::class,
    ];

    protected $commands = [
        #    Console\ListCommand::class,
    ];

    protected $bindings = [
        'codex.document' => Documents\Document::class,
        'codex.project'  => Projects\Project::class,
        'codex.menu'     => Menus\Menu::class,
    ];

    protected $singletons = [
        'codex.addons' => Addons\Addons::class,
    ];

    protected $aliases = [
        'codex.log' => Contracts\Log::class,
    ];

    protected $weaklings = [
        'fs' => \Sebwite\Filesystem\Filesystem::class,
    ];


    public function register()
    {
        $app = parent::register();

        $this->app->instance('codex.addons', $addons = Addons\Addons::getInstance());

        $this->registerDefaultFilesystem();

        $this->registerCodex();

        $log = $this->registerLogger();

        $log->info('init');

        if ( $this->app[ 'config' ][ 'codex.routing.enabled' ] === true ) {
            $this->registerRouting();
        }

        $addons->registerInPath(__DIR__ . '/Addons/Filters');

        return $app;
    }


    /**
     * registerLogger method
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return \Codex\Core\Log\Writer
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

        $this->app[ 'codex.addons' ]->hooks->hook('constructed', function (Codex $codex) {
            $codex->extend('projects', Projects\Projects::class);
            $codex->extend('menus', Menus\Menus::class);
            $codex->extend('theme', Theme::class);
        });

        $this->share('codex', Codex::class, [ ], true);
        $this->app->alias('codex', Contracts\Codex::class);

        $this->app[ 'codex.addons' ]->hooks->hook('project:construct', function (Project $project) {
            $project->extend('documents', Documents\Documents::class);
        });
    }

    protected function registerDefaultFilesystem()
    {
        $this->app->make('filesystem')->extend('codex-local', function (LaravelApplication $app, array $config = [ ]) {
            $flysystemAdapter    = new Filesystem\Local($config[ 'root' ]);
            $flysystemFilesystem = new Flysystem($flysystemAdapter);
            return new FilesystemAdapter($flysystemFilesystem);
        });
    }

    protected function registerRouting()
    {
        $this->app->register(Http\RouteServiceProvider::class);
    }


}
