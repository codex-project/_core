<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next;


use Codex\Core\Contracts\Log;

use Codex\Core\Next\Addon\Addons;
use Codex\Core\Next\Contracts\Bootable;
use Codex\Core\Next\Contracts\Codex as CodexContract;
use Codex\Core\Next\Contracts\Extendable;
use Codex\Core\Next\Contracts\Hookable;
use Codex\Core\Next\Projects\Project;
use Codex\Core\Next\Traits;
use Herrera\Version\Parser;
use Herrera\Version\Version;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\View;
use Sebwite\Support\Filesystem;


/**
 * This is the class Codex.
 *
 * @package        Codex\Core
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 *
 *
 *
 * @property \Codex\Core\Next\Theme\Theme       $theme
 * @property \Codex\Core\Next\Theme\Assets      $assets
 * @property \Codex\Core\Next\Projects\Projects $projects
 * @property \Codex\Core\Next\Menus\Menus       $menus
 *
 */
class Codex implements
    CodexContract,
    Extendable,
    Hookable,
    Bootable
{
    use Traits\ExtendableTrait,
        Traits\HookableTrait,
        Traits\ObservableTrait,
        Traits\BootableTrait,

        Traits\FilesTrait,
        Traits\ConfigTrait;

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
    protected $rootDir;

    protected $addons;

    /**
     * @param \Illuminate\Contracts\Container\Container                             $container
     * @param \Illuminate\Contracts\Filesystem\Filesystem                           $files
     * @param \Illuminate\Contracts\Config\Repository                               $config
     * @param \Illuminate\Contracts\Cache\Repository                                $cache
     * @param \Codex\Core\Contracts\Log                                             $log
     * @param \Codex\Core\Contracts\Menus\MenuFactory|\Components\Menus\MenuFactory $menus The menu factory
     */
    public function __construct(Container $container, Filesystem $files, Cache $cache, Log $log, array $config = [ ])
    {
        $this->setContainer($container);
        $this->setConfig($config);
        $this->setFiles($files);

        $this->addons = new Addons;

        $this->cache = $cache;
        $this->rootDir = config('codex.root_dir');
        $this->log = $log;

        // 'factory:ready' is called after parameters have been set as class properties.
        $this->hookPoint('construct', [ $this ]);

        // 'factory:done' called after all factory operations have completed.
        $this->hookPoint('constructed', [ $this ]);
    }


    # Config

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

    # Helper functions

    public function stack($viewName, $data = null, $appendTo = 'codex::layouts.default')
    {
        $this->container->make('events')->listen('composing: ' . $appendTo, function (View $view) use ($viewName, $data) {

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

    # Getters / setters

    /**
     * Get root directory.
     *
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
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
