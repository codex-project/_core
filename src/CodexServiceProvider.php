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

use Sebwite\Support\ServiceProvider;
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
    protected $dir = __DIR__;

    protected $configFiles = [ 'codex' ];

    protected $viewDirs = [ 'views' => 'codex' ];

    protected $commands = [
        #'codex.list' => Console\ListCommand::class
    ];

    protected $providers = [
        \Radic\BladeExtensions\BladeExtensionsServiceProvider::class,
    ];

    protected $bindings = [
        'codex.document.html' => Documents\HtmlDocument::class,
        'codex.project'       => Projects\Project::class,
        'codex.menu'          => Menus\Menu::class,
    ];

    protected $singletons = [
        'codex'        => Codex::class,
        'codex.addons' => Addons\Addons::class,
    ];

    protected $aliases = [
        'codex'              => Contracts\Codex::class,
        'codex.log'          => Contracts\Log::class,
        Addons\Addons::class => Addons\Addons::class,
    ];

    protected $weaklings = [
        'fs' => \Sebwite\Filesystem\Filesystem::class
    ];

    public function register()
    {
        $app = parent::register();

        if($this->app['config']['codex.dev.enabled'] === true){
            $this->app->register('Codex\Dev\DevServiceProvider');
        }

        $this->registerLogger();

        $this->registerCodexBinding();

        $this->registerDefaultFilesystem();

        if($this->app['config']['codex.routing.enabled'] === true) {
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

    /**
     * registerCodexBinding method
     *
     * @param $app
     */
    protected function registerCodexBinding()
    {
        $this->app->when(Codex::class)
            ->needs('$config')
            ->give($this->app[ 'config' ][ 'codex' ]);
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
