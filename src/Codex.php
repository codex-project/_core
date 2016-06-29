<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright $today.year (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex;


use Codex\Contracts;
use Codex\Projects\Project;
use Codex\Support\Extendable;
use Codex\Traits;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Filesystem\Filesystem;


/**
 * This is the main Codex factory. It gives access to several sub-components and helper functions.
 *
 * @package        Codex\Core
 * @author         Sebwite
 *
 * @property-read \Codex\Addons\Factory       $addons       The addons instance
 * @property-read \Codex\Projects\Projects    $projects     The projects instance
 * @property-read \Codex\Menus\Menus          $menus        The menus instance
 * @property-read \Codex\Addon\Auth\CodexAuth $auth         The auth addon instance
 * @property-read \Codex\Addon\Git\CodexGit   $git          The theme instance
 * @property-read \Codex\Addon\Phpdoc\Phpdoc  $phpdoc       The phpdoc instance
 * @property-read \Codex\Helpers\ThemeHelper  $theme        The theme instance
 *
 *
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 * @hookPoint      constructed
 *
 */
class Codex extends Extendable implements Contracts\Codex, Arrayable
{
    use Traits\FilesTrait,
        Traits\ConfigTrait;

    const SHOW_MASTER_BRANCH = 0;
    const SHOW_LAST_VERSION = 1;
    const SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH = 2;
    const SHOW_CUSTOM = 3;


    /**
     * The codex log writer instance
     *
     * @var \Codex\Contracts\Log\Log
     */
    protected $log;

    /**
     * The cache repository instance
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Path to the directory containing all docs
     *
     * @var string
     */
    protected $docsDir;

    //protected $log;


    /**
     * Codex constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container The container instance
     * @param \Illuminate\Filesystem\Filesystem         $files     The filesystem instance
     * @param \Illuminate\Contracts\Cache\Repository    $cache     The cache instance
     * @param \Codex\Contracts\Log\Log                  $log       The log instance
     *
     * @hook constructed After Codex has been constructed
     */
    public function __construct(Container $container, Filesystem $files, Cache $cache, Contracts\Log\Log $log)
    {
        $this->setContainer($container);
        $this->setConfig(config('codex'));
        $this->setFiles($files);

        $this->cache = $cache;
        $this->log   = $log;

        $this->docsDir = config('codex.paths.docs');
        if ( path_is_relative($this->docsDir) )
        {
            $this->docsDir = base_path($this->docsDir);
        }

        // 'factory:done' called after all factory operations have completed.
        $this->hookPoint('constructed', [ $this ]);
    }

//# GETTERS & SETTERS
    public function getCachedLastModified($key, $lastModified, \Closure $create)
    {
        /** @var \Illuminate\Contracts\Cache\Repository $cache */
        $cache = app('cache')->driver('file');
        $clm   = (int)$cache->get($key . '.lastModified', 0);
        $plm   = (int)$lastModified;
        if ( $clm !== $plm )
        {
            $cache->forever($key, $create());
            $cache->forever($key . '.lastModified', $plm);
        }
        return $cache->get($key);
    }

    /**
     * Creates a error response. To be used in controllers/middleware
     *
     * @param string   $title  The error title
     * @param string   $text   The error text
     * @param int      $code   The HTTP code. 500 Internal Server Error by default
     * @param bool|int $goBack If set to false, it will not display the go back link. If set to a integer value, it will use the integer value as history.back parameter.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function error($title, $text, $code = 500, $goBack = true)
    {
        return response(view($this->view('error'), compact('title', 'text', 'goBack'))->render(), $code);
    }

    /**
     * Returns a Codex view name
     *
     * @param string $name The simple name
     *
     * @return string The namespaced view name
     */
    public function view($name)
    {
        return $this->addons->view($name);
    }

    /**
     * Push a view to a stack
     *
     * @param string     $stackName The name of the stack
     * @param string     $viewName  The namespaced name of the view
     * @param array|null $data      (optional) The view data array
     * @param string     $appendTo  (optional) The view to attach this to
     *
     * @return Codex
     */
    public function pushToStack($stackName, $viewName, $data = null, $appendTo = 'codex::layouts.default')
    {
        $this->container->make('events')->listen('composing: ' . $appendTo, function ($view) use ($stackName, $viewName, $data)
        {
            /** @var \Illuminate\View\View $view */
            if ( $data instanceof \Closure )
            {
                $data = $this->container->call($data, [ $this ]);
                $data = is_array($data) ? $data : [ ];
            }
            elseif ( $data === null )
            {
                $data = [ ];
            }
            if ( ! is_array($data) )
            {
                throw new \InvalidArgumentException("appendSectionsView data is not a array");
            }

            $content = $view->getFactory()->make($viewName, $data)->render();
            $view->getFactory()->startPush($stackName, $content);
        });

        return $this;
    }

    /**
     * Generate a URL to a project's default page and version.
     *
     * @param  Project|string $project A Project class instance or project name
     * @param  null|string    $ref     The ref to generate the URL for. If not provided it'll use the default ref
     * @param  null|string    $doc     The document to generate the URL for.
     *
     * @return string
     */
    public function url($project = null, $ref = null, $doc = null)
    {
        $uri = $this->config('base_route');

        if ( ! is_null($project) )
        {

            if ( ! $project instanceof Project )
            {
                $project = $this->projects->get($project);
            }


            $uri = "{$uri}/{$project->getName()}";

            $ref = $ref === null ? $project->getDefaultRef() : $ref;
            $doc = $doc === null ? '' : "/{$doc}";
            $uri = "{$uri}/{$ref}{$doc}";
        }

        return url($uri);
    }

    /**
     * Writes a log message to the codex log file
     *
     * @param string $level   The log level
     * @param string $message The message to log
     * @param array  $context (optional) The context to log
     */
    public function log($level, $message, $context = [ ])
    {

        $this->log->log($level, $message, $context);
    }

    /**
     * The path to the directory where all documentation projects reside
     *
     * @return string
     */
    public function getDocsPath()
    {
        return $this->docsDir;
    }

    /**
     * Get cache.
     *
     * @return Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Set cache.
     *
     * @param  \Illuminate\Cache\CacheManager $cache
     *
     * @return Codex
     */
    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    public function getLog()
    {
        return $this->log;
    }

    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    public function toArray()
    {
        return [
            'config'   => $this->config,
            'projects' => $this->projects->toArray(),
            'addons'   => $this->addons->toArray(),
            'menus'    => $this->menus->toArray(),
        ];
    }

    public function __get($name)
    {
        if ( $name === 'addons' )
        {
            return $this->container->make('codex.addons');
        }
        return parent::__get($name);
    }

}
