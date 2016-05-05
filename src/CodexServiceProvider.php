<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core;

use Codex\Core\Log\Writer;
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

    protected $providers = [
        \Radic\BladeExtensions\BladeExtensionsServiceProvider::class,
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

    protected $codexExtensions = [
        'projects' => Projects\Projects::class,
        'menus'    => Menus\Menus::class
    ];

    public function register()
    {
        $app = parent::register();

        $app->instance('codex.addons', Addons\Addons::getInstance());

        $this->registerDefaultFilesystem();

        $this->registerCodex();

        $log = $this->registerLogger();

        $log->info('init');

        if ( $this->app[ 'config' ][ 'codex.dev.enabled' ] === true ) {
           # $this->app->register('Codex\Dev\DevServiceProvider');
        }

        if ( $this->app[ 'config' ][ 'codex.routing.enabled' ] === true ) {
            $this->registerRouting();
        }

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
        $this->share('codex', Codex::class, [], true);
        $this->app->alias('codex',  Contracts\Codex::class);
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
        $this->app->register($this->app[ 'config' ][ 'codex.routing.provider' ]);
    }


}
