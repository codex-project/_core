<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core;


use Codex\Core\Contracts;
use Codex\Core\Documents\Document;
use Codex\Core\Http\Controllers\CodexController;
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
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 *
 *
 *
 * @property \Codex\Core\Theme\Theme       $theme
 * @property \Codex\Core\Theme\Assets      $assets
 * @property \Codex\Core\Projects\Projects $projects
 * @property \Codex\Core\Menus\Menus       $menus
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
        Traits\ConfigTrait;

    protected $extensions = [
        'projects' => Projects\Projects::class,
        'menus'    => Menus\Menus::class
        #'addons'   => Addons\Addons::class,
    ];

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


    # Config

    /**
     * Codex constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Codex\Core\Contracts\Addons              $addons
     * @param \Sebwite\Support\Filesystem               $files
     * @param \Illuminate\Contracts\Cache\Repository    $cache
     * @param \Codex\Core\Contracts\Log                 $log
     * @param array                                     $config
     */
    public function __construct(Container $container, Filesystem $files, Cache $cache, Contracts\Log $log, array $config = [ ])
    {
        $this->setContainer($container);
        $this->setConfig($config);
        $this->setFiles($files);

        $this->cache   = $cache;
        $this->docsDir = config('codex.docs_dir');
        $this->log     = $log;
        // 'factory:done' called after all factory operations have completed.
        $this->hookPoint('constructed', [ $this ]);
    }

    /**
     * getAddons method
     * @return Addons\Addons
     */
    public function getAddons()
    {
        return $this->container->make('codex.addons');
    }

    public function registerTheme($name, $views = [ ])
    {
        $this->getAddons()->registerTheme($name, $views); //themes[ $name ] = $views;
        return $this;
    }

    # Helper functions

    public function mergeDefaultProjectConfig($config)
    {
        $this->setConfig(
            'default_project_config',
            array_replace_recursive(
                $this->config('default_project_config'),
                is_array($config) ? $config : config($config)
            )
        );
    }

    /** Add a view to a view stack */
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
     * @param  Project|string $project A Project instance or projectName, will auto-resolve
     * @param  null|string    $ref
     * @param  null|string    $doc
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
     * getLaravelVersion method
     * @return Version
     */
    public function getLaravelVersion()
    {
        return Parser::toVersion(app()->version());
    }

    protected $routeExclusions = [ ];

    public function routeExclusion($name)
    {
        $this->routeExclusions[] = $name; //        $document->where('projectSlug', '^((?!' . Extender::getExcludedProjectNames(true) . ').*?)$');
    }

    public function hasRouteExclusions()
    {
        return count($this->routeExclusions) > 0;
    }

    public function getRouteExclusions()
    {
        return $this->routeExclusions;
    }
    # Getters / setters

    /**
     * Writes a log message to the codex log file
     *
     * @param       $level
     * @param       $message
     * @param array $context
     */
    public function log($level, $message, $context = [ ])
    {
        return $this->log->log($level, $message, $context);
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

}
