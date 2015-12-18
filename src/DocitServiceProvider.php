<?php
/**
* Part of the Docit PHP packages.
*
* MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core;

use Docit\Support\ServiceProvider;
use Docit\Core\Filters\FrontMatterFilter;
use Docit\Core\Filters\ParsedownFilter;
use Docit\Core\Traits\DocitProviderTrait;
use Illuminate\Contracts\Foundation\Application;

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
        Providers\LogServiceProvider::class,
        Providers\ConsoleServiceProvider::class,
        Providers\RouteServiceProvider::class
    ];

    /**
     * @var array
     */
    protected $singletons = [
        'docit' => Factory::class,
        'docit.menus' => Menus\MenuFactory::class
    ];

    /**
     * @var array
     */
    protected $aliases = [
        'docit' => Contracts\Factory::class,
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

}
