<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core;


use Codex\Core\Contracts;
use Codex\Core\Projects\Project;
use Codex\Core\Traits;
use Herrera\Version\Parser;
use Herrera\Version\Version;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;


/**
 * This is the class Codex.
 *
 * @package        Codex\Core
 * @author         Sebwite
 * @property-read \Codex\Core\Addons\Addons     $addons
 * @property-read \Codex\Core\Projects\Projects $projects
 * @property-read \Codex\Core\Menus\Menus       $menus
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 *
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
        Traits\ConfigTrait {
        Traits\ExtendableTrait::__get as ___get;
    }


    /**
     * The codex log writer instance
     *
     * @var \Codex\Core\Contracts\Log
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
     * @param \Codex\Core\Contracts\Log                 $log       The log instance
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

        $this->addons->findAndRegisterAll();

        // 'factory:done' called after all factory operations have completed.
        $this->hookPoint('constructed', [ $this ]);
    }

    /**
     * Add a view to a view stack
     *
     * @param string     $viewName The namespaced name of the view
     * @param array|null $data     (optional) The view data array
     * @param string     $appendTo
     *
     * @return Codex
     */
    public function stack($viewName, $data = null, $appendTo = 'codex::layouts.default')
    {
        $this->container->make('events')->listen('composing: ' . $appendTo, function ($view) use ($viewName, $data) {
            /** @var \Illuminate\Contracts\View\View $view */

            if ( $data instanceof \Closure ) {
                $data = $this->container->call($data, [ $this ]);
                $data = is_array($data) ? $data : [ ];
            } elseif ( $data === null ) {
                $data = [ ];
            }
            if ( !is_array($data) ) {
                throw new \InvalidArgumentException("appendSectionsView data is not a array");
            }
            $view->getFactory()->make($viewName, $data)->render();
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

        if ( !is_null($project) ) {

            if ( !$project instanceof Project ) {
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
     * @param       $level
     * @param       $message
     * @param array $context
     */
    public function log($level, $message, $context = [ ])
    {
        $this->log->log($level, $message, $context);
    }

    public function view($name)
    {
        return $this->addons->view($name);
    }

    /**
     * getLaravelVersion method
     * @return Version
     */
    public function getLaravelVersion()
    {
        return Parser::toVersion(app()->version());
    }

    /**
     * Get root directory.
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
     * @return Factory
     */
    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * get log value
     *
     * @return Log
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set the log value
     *
     * @param Log $log
     *
     * @return Factory
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }


    public function __get($name)
    {
        if ( $name === 'addons' ) {
            return $this->container->make('codex.addons');
        }
        return $this->___get($name);
    }

}
