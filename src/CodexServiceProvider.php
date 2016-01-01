<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core;

use Codex\Core\Filters\FrontMatterFilter;
use Codex\Core\Filters\ParsedownFilter;
use Codex\Core\Log\Writer;
use Codex\Core\Traits\ProvidesCodex;
use Illuminate\Contracts\Foundation\Application;
use Monolog\Logger as Monolog;
use Sebwite\Support\ServiceProvider;

/**
 * Codex service provider.
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class CodexServiceProvider extends ServiceProvider
{
    use ProvidesCodex;

    /**
     * @var string
     */
    protected $dir = __DIR__;

    /**
     * Collection of configuration files.
     *
     * @var array
     */
    protected $configFiles = [ 'codex' ];

    /**
     * Collection of bound instances.
     *
     * @var array
     */
    protected $provides = [ 'codex' ];

    /**
     * @var array
     */
    protected $viewDirs = [ 'views' => 'codex' ];

    /**
     * @var array
     */
    protected $assetDirs = [ 'assets' => 'codex' ];

    /**
     * @var array
     */
    protected $providers = [
        \Sebwite\Support\SupportServiceProvider::class,
        Providers\ConsoleServiceProvider::class,
        Providers\RouteServiceProvider::class
    ];

    /**
     * @var array
     */
    protected $singletons = [
        'codex'       => Factory::class,
        'codex.menus' => Menus\MenuFactory::class
    ];

    /**
     * @var array
     */
    protected $aliases = [
        'codex'       => Contracts\Factory::class,
        'codex.log'   => Contracts\Log::class,
        'codex.menus' => Contracts\Menus\MenuFactory::class
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
        $this->addCodexFilter('front_matter', FrontMatterFilter::class);
        $this->addCodexFilter('parsedown', ParsedownFilter::class);
    }

    /**
     * registerLogger method
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
*@return \Codex\Core\Log\Writer
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
