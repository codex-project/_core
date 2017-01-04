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

use Closure;
use Codex\Codex;
use Illuminate\Contracts\Foundation\Application;

class CodexMiddleware
{

    /**
     * The Laravel Application
     *
     * @var Application
     */
    protected $app;

    /**
     * @var \Codex\Codex
     */
    protected $codex;

    /**
     * Create a new middleware instance.
     *
     * @param Application        $app
     * @param Codex|\Codex\Codex $codex
     */
    public function __construct(Application $app, Codex $codex)
    {
        $this->app = $app;
        $this->codex = $codex;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $codex = $this->codex;


        return $response;
    }
}
