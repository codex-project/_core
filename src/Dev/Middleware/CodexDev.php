<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Dev\Middleware;

use Closure;
use Codex\Codex;
use Codex\Support\Collection;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;

class CodexDev
{
    /**
     * The App container
     *
     * @var Container
     */
    protected $container;

    /**
     * @var \Codex\Codex
     */
    protected $codex;

    /**
     * Create a new middleware instance.
     *
     * @param  Container       $container
     * @param  LaravelDebugbar $debugbar
     */
    public function __construct(Container $container, Codex $codex)
    {
        $this->container = $container;
        $this->codex = $codex;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            /** @var \Illuminate\Http\Response $response */
            $response = $next($request);
        } catch (Exception $e) {
            $response = $this->handleException($request, $e);
        }
        if ($this->codex->config('dev.enabled', false) === true && $this->codex->config('dev.debugbar', false) === true) {
        }
        $this->codex->config('dev.debugbar', false) && $this->handleDebugbar($response);
        $this->codex->config('dev.hookpoints', false) && $this->handleHookPoints();

        return $response;
    }

    /**
     * @param \Illuminate\Http\Response $response
     */
    protected function handleDebugbar($response)
    {

        $content = $response->getContent();

        $assets = [
            'debugbar.css',
            'codex-debugbar.css',
            #   'codex-debugbar.js'
        ];
        $out = '';
        foreach ($assets as $style) {
            $out .= '<link type="text/css" rel="stylesheet" href="' . asset('vendor/codex-dev/' . $style) . '"/>';
        }
        $content = str_replace('</body>', $out . '</body>', $content);

        $response->setContent($content);
    }

    protected function handleHookPoints()
    {
    }

    /**
     * Handle the given exception.
     *
     * (Copy from Illuminate\Routing\Pipeline by Taylor Otwell)
     *
     * @param            $passable
     * @param  Exception $e
     *
     * @return mixed
     * @throws Exception
     */
    protected function handleException($passable, Exception $e)
    {
        if (!$this->container->bound(ExceptionHandler::class) || !$passable instanceof Request) {
            throw $e;
        }

        $handler = $this->container->make(ExceptionHandler::class);

        $handler->report($e);

        return $handler->render($passable, $e);
    }
}
