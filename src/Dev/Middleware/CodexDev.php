<?php namespace Codex\Dev\Middleware;


use Closure;
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
     * Create a new middleware instance.
     *
     * @param  Container       $container
     * @param  LaravelDebugbar $debugbar
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
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
        }
        catch (Exception $e) {
            $response = $this->handleException($request, $e);
        }

        $content = $response->content();

        $assets = [
            'debugbar.css',
            'codex-debugbar.css',
         #   'codex-debugbar.js'
        ];
        $out = '';
        foreach($assets as $style){
            $out .= '<link type="text/css" rel="stylesheet" href="' . asset('vendor/codex-dev/' . $style) . '"/>';
        }
        $content = str_replace('</body>', $out . '</body>', $content);

        $response->setContent($content);

        return $response;
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
        if ( !$this->container->bound(ExceptionHandler::class) || !$passable instanceof Request ) {
            throw $e;
        }

        $handler = $this->container->make(ExceptionHandler::class);

        $handler->report($e);

        return $handler->render($passable, $e);
    }
}
