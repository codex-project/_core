<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next;

use Codex\Core\Contracts\Codex as CodexContract;
use Codex\Core\Contracts\Log;
use Codex\Core\Log\Writer;
use Codex\Core\Next\Addon\Hook\Hook;
use Codex\Core\Next\Addon\Hook\Point;
use Codex\Core\Next\Contracts\Extendable;
use Illuminate\Contracts\Foundation\Application;
use Monolog\Logger as Monolog;
use Sebwite\Support\ServiceProvider;

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

    protected $singletons = [
        'codex' => Codex::class,
    ];

    protected $aliases = [
        'codex'     => CodexContract::class,
        'codex.log' => Log::class,
    ];

    public function register()
    {
        $app = parent::register();

        $this->registerLogger($app);

        $app->when(Codex::class)
            ->needs('$config')
            ->give($app[ 'config' ][ 'codex' ]);

        $app->booting(function (Application $app) {
            foreach ( $app[ 'config' ][ 'codex.extensions' ] as $extendable => $bindings ) {
                $app->resolving($extendable, function (Extendable $instance) use ($bindings) {
                    foreach ( $bindings as $binding => $extension ) {
                        $instance->extend($binding, $extension);
                    }
                });
            }
        });

        return $app;
    }

    /**
     * registerLogger method
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return \Codex\Core\Log\Writer
     */
    protected function registerLogger(Application $app)
    {
        $app->instance('codex.log', $log = new Writer(
            new Monolog($app->environment()),
            $app[ 'events' ]
        ));
        $log->useFiles($app[ 'config' ][ 'codex.log.path' ]);

        return $log;
    }

}
