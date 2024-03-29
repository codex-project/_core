<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Http;

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
class HttpServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in the Codex routes
     * file. In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Codex\Http\Controllers';


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
     *
     * @return void
     */
    public function map(Router $router)
    {
        $useMiddleware = version_compare($this->app->version(), '5.2.0', '>=') === true;

        // web
        $router->group([
            'as'         => 'codex.',
            'prefix'     => config('codex.http.base_route'),
            'namespace'  => $this->namespace,
            'middleware' => $useMiddleware ? [ 'web' ] : [ ],
        ], function () {
            require __DIR__ . '/routes.php';
        });
        // dev
        $router->group([
            'as'         => 'codex.dev.',
            'prefix'     => config('codex.base_route') . '/dev',
            'namespace'  => $this->namespace,
            'middleware' => $useMiddleware ? [ 'web' ] : [ ],
        ], function () {
            require __DIR__ . '/routes.dev.php';
        });

        // api v1
        $router->group([
            'as'         => 'codex.api.v1.',
            'prefix'     => config('codex.http.base_route') . '/api/v1',
            'namespace'  => $this->namespace . '\Api\V1',
            'middleware' => $useMiddleware ? [ 'api' ] : [ ],
        ], function () {
            require __DIR__ . '/routes.api.php';
        });
    }
}
