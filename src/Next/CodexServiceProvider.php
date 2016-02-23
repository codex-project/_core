<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next;

use Codex\Core\Contracts\Log;
use Codex\Core\Exception\ConfigFileNotPublished;
use Codex\Core\Log\Writer;
use Codex\Core\Next\Contracts\Extendable;
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
 */
class CodexServiceProvider extends ServiceProvider
{
    protected $dir = __DIR__;

    protected $configPath = '../../config';

    protected $configFiles = [ 'codex' ];


    protected $bindings = [
        'codex.document' => Documents\Document::class,
        'codex.project'  => Projects\Project::class,
        'codex.menu'     => Menus\Menu::class,
    ];

    protected $extensions = [
        'codex' => [
            'projects' => Projects\Projects::class,
            'menus'    => Menus\Menus::class,
            'theme'    => Theme\Theme::class,
        ],
        'codex.project' => [
            'documents' => Documents\Documents::class
        ]
    ];

    protected $singletons = [
        'codex' => Codex::class,
    ];

    protected $aliases = [
        'codex'     => Contracts\Codex::class,
        'codex.log' => Log::class,
    ];

    public function boot()
    {
        $app = parent::boot();
        return $app;
    }

    public function register()
    {
        $app = parent::register();

        if ( config('app.debug', false) === false ) {
            $this->ensureConfig();
        }

        $this->registerLogger();

        $this->registerCodexBinding();

        $this->registerExtensions();

        $this->registerDefaultFilesystem();

        return $app;
    }

    protected function ensureConfig()
    {

        if ( !$this->hasPublishedConfig() ) {
            $this->publishConfigFile();
        }
        if ( !$this->hasPublishedConfig() ) {
            throw ConfigFileNotPublished::in($this)->filePath($this->getPublishedConfigPath());
        }
    }

    protected function hasPublishedConfig()
    {
        $fs = $this->app->make('fs');
        return $fs->exists($this->getPublishedConfigPath()) || $fs->isFile($this->getPublishedConfigPath());
    }

    protected function getPublishedConfigPath()
    {
        return config_path('codex.php');
    }

    protected function publishConfigFile()
    {
        $fs = $this->app->make('fs');
        $fs->copy($this->getConfigFilePath('codex'), $this->getPublishedConfigPath());
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

    /**
     * registerExtensions method
     *
     * @param $app
     */
    protected function registerExtensions()
    {
        $this->app->booting(function (LaravelApplication $app) {
            foreach ( $this->extensions as $name => $extensions ) {
                $app->resolving($name, function (Extendable $instance) use ($extensions) {
                    foreach ( $extensions as $binding => $extension ) {
                        $instance->extend($binding, $extension);
                    }
                });
            }
        });
    }

    protected function registerDefaultFilesystem()
    {
        $config = $this->app->make('config');
        $config->get('codex.filesystems');
        $config->set('codex.filesystems.local');
        $fsm = $this->app->make('filesystem');
        $fsm->extend('codex-local', function (LaravelApplication $app, array $config = [ ]) use ($fsm) {
            #return new Filesystem\Local($config['root']);
            $flysystemAdapter    = new Filesystem\Local($config[ 'root' ]);
            $flysystemFilesystem = new Flysystem($flysystemAdapter);
            return new FilesystemAdapter($flysystemFilesystem);
        });
    }

}
