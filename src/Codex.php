<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex;


use Codex\Contracts;
use Codex\Log\Writer;
use Codex\Projects\Project;
use Codex\Traits;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;


/**
 * This is the main Codex factory. It gives access to several sub-components and helper functions.
 *
 * @package        Codex\Core
 * @author         Sebwite
 *
 * @property-read \Codex\Addons\Addons     $addons   The addons instance
 * @property-read \Codex\Projects\Projects $projects The projects instance
 * @property-read \Codex\Menus\Menus       $menus    The menus instance
 * @property-read \Codex\Addon\Auth\Auth   $auth     The auth addon instance
 * @property-read \Codex\Theme             $theme    The theme instance
 * @property-read \Codex\Theme             $theme2    The theme instance
 *
 *
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 * @hookPoint      constructed
 *
 */
class Codex implements
    Contracts\Codex,
    Contracts\Extendable,
    Contracts\Hookable,
    Contracts\Bootable
{
    use Traits\ExtendableTrait,
        Traits\HookableTrait,
        Traits\ObservableTrait,
        Traits\BootableTrait,

        Traits\FilesTrait,
        Traits\ConfigTrait
    {
        Traits\ExtendableTrait::__get as ___get;
    }


    /**
     * The codex log writer instance
     *
     * @var \Codex\Contracts\Log
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


    /**
     * Codex constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container The container instance
     * @param \Illuminate\Filesystem\Filesystem         $files     The filesystem instance
     * @param \Illuminate\Contracts\Cache\Repository    $cache     The cache instance
     * @param \Codex\Contracts\Log                      $log       The log instance
     *
     */
    public function __construct(Container $container, Filesystem $files, Cache $cache, Contracts\Log $log)
    {
        $this->setContainer($container);
        $this->setConfig(config('codex'));
        $this->setFiles($files);

        $this->cache   = $cache;
        $this->docsDir = config('codex.docs_dir');
        $this->log     = $log;


        // 'factory:done' called after all factory operations have completed.
        $this->hookPoint('constructed', [ $this ]);
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
            if ( !is_array($data) )
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

        if ( !is_null($project) )
        {

            if ( !$project instanceof Project )
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
     * The path to the directory where all documentation projects reside
     *
     * @return string
     */
    public function getDocsDir()
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

    /**
     * Get the log instance
     *
     * @return Writer
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set the log value
     *
     * @param Writer|mixed $log The log instance to replace
     *
     * @return Codex
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }


    public function __get($name)
    {
        if ( $name === 'addons' )
        {
            return $this->container->make('codex.addons');
        }
        return $this->___get($name);
    }

}
