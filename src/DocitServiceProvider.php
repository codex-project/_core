<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core;

use Docit\Core\Filters\FrontMatterFilter;
use Docit\Core\Filters\ParsedownFilter;
use Docit\Core\Log\Writer;
use Docit\Core\Traits\DocitProviderTrait;
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
class DocitServiceProvider extends ServiceProvider
{
    use DocitProviderTrait;

    /**
     * @var string
     */
    protected $dir = __DIR__;

    /**
     * Collection of configuration files.
     *
     * @var array
     */
    protected $configFiles = [ 'docit' ];

    /**
     * Collection of bound instances.
     *
     * @var array
     */
    protected $provides = [ 'docit' ];

    /**
     * @var array
     */
    protected $viewDirs = [ 'views' => 'docit' ];

    /**
     * @var array
     */
    protected $assetDirs = [ 'assets' => 'docit' ];

    /**
     * @var array
     */
    protected $providers = [
        \Docit\Support\SupportServiceProvider::class,
        Providers\ConsoleServiceProvider::class,
        Providers\RouteServiceProvider::class
    ];

    /**
     * @var array
     */
    protected $singletons = [
        'docit'       => Factory::class,
        'docit.menus' => Menus\MenuFactory::class
    ];

    /**
     * @var array
     */
    protected $aliases = [
        'docit'       => Contracts\Factory::class,
        'docit.log'   => Contracts\Log::class,
        'docit.menus' => Contracts\Menus\MenuFactory::class
    ];

    /**
     * Register bindings in the container.
     *
     * @return Application
     */
    public function register()
    {
        $app = parent::register();
        $this->registerLogger($app);
        $this->registerFilters();
    }

    /**
     * Register the core filters.
     *
     * @return void
     */
    protected function registerFilters()
    {
        $this->addDocitFilter('front_matter', FrontMatterFilter::class);
        $this->addDocitFilter('parsedown', ParsedownFilter::class);
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
        $log->useFiles($app[ 'config' ][ 'docit.log.path' ]);

        return $log;
    }
}
