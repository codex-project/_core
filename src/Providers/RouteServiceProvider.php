<?php
namespace Codex\Core\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

/**
 * Codex route service provider
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in the Codex routes
     * file. In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Codex\Core\Http\Controllers';

    /**
     * Boot Codex's route service provider.
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
     * Define the routes for Codex.
     *
     * @param Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group([ 'prefix' => config('codex.base_route'), 'namespace' => $this->namespace ], function ($router)
        {

            require(realpath(__DIR__ . '/../Http/routes.php'));
        });
    }
}
