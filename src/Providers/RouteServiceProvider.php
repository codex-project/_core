<?php
namespace Docit\Core\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

/**
 * Docit route service provider
 *
 * @package   Docit\Core
 * @author    Docit Project Dev Team
 * @copyright Copyright (c) 2015, Docit Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in the Docit routes
     * file. In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Docit\Core\Http\Controllers';

    /**
     * Boot Docit's route service provider.
     *
     * @param Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
    }

    /**
     * Set the root controller namespace for the application.
     *
     * @return void
     */
    protected function setRootControllerNamespace()
    {
        // Intentionally left empty to prevent overwriting the
        // root controller namespace.
    }

    /**
     * Define the routes for Docit.
     *
     * @param Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group([ 'prefix' => config('docit.base_route'), 'namespace' => $this->namespace ], function ($router)
        {

            require(realpath(__DIR__ . '/../Http/routes.php'));
        });
    }
}
