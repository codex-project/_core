<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core\Providers;

use Docit\Core\Log\Writer;
use Docit\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Monolog\Logger as Monolog;


/**
 * Docit service provider.
 *
 * @package   Docit\Core
 * @author    Docit Project Dev Team
 * @copyright Copyright (c) 2015, Docit Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class LogServiceProvider extends ServiceProvider
{
    protected $aliases = [
        'docit.log' => \Docit\Core\Contracts\Log::class
    ];

    public function register()
    {
        $app = parent::register();
        $log = $this->registerLogger($app);
        $this->configureSingleHandler($app, $log);
    }


    /**
     * registerLogger method
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @return \Docit\Core\Log\Writer
     */
    protected function registerLogger(Application $app)
    {
        $app->instance('docit.log', $log = new Writer(
            new Monolog($app->environment()), $app[ 'events' ])
        );

        return $log;
    }


    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @param  \Illuminate\Log\Writer                       $log
     * @return void
     */
    protected function configureSingleHandler(Application $app, Writer $log)
    {
        $log->useFiles($app[ 'config' ][ 'docit.log.path' ]);
    }

}
