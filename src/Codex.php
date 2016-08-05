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
use Codex\Exception\CodexException;
use Codex\Projects\Project;
use Codex\Support\Collection;
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
 * @ property-read \Codex\Addons\Factory       $addons       The addons instance
 * @property-read \Codex\Dev\Dev              $dev          The dev instance
 * @property-read \Codex\Projects\Projects    $projects     The projects instance
 * @property-read \Codex\Menus\Menus          $menus        The menus instance
 * @property-read \Codex\Addon\Auth\CodexAuth $auth         The auth addon instance
 * @property-read \Codex\Addon\Git\CodexGit   $git          The theme instance
 * @property-read \Codex\Addon\Phpdoc\Phpdoc  $phpdoc       The phpdoc instance
 * @property-read \Codex\Helpers\CacheHelper  $cache        The cache instance
 * @property-read \Codex\Helpers\ThemeHelper  $theme        The theme instance
 *
 *
 *
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 * @hookPoint      constructed
 * @example
 * <?php
 * codex()->projects->get('codex')->documents->get('index')->render();
 *
 */
class Codex extends Extendable implements Arrayable
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
     * @example
     * <?php
     * codex()->projects->get('codex')->documents->get('index')->render();
     */
    protected $docsPath;

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
     * @example
     * <?php
     * codex()->projects->get('codex')->documents->get('index')->render();
     */
    public function __construct(Container $container, Filesystem $files, Cache $cache, Contracts\Log\Log $log)
    {
        $this->setContainer($container);
        $this->setFiles($files);

        $this->cache = $cache;
        $this->log   = $log;

        $this->docsPath = config('codex.paths.docs');
        if ( path_is_relative($this->docsPath) ) {
            $this->docsPath = base_path($this->docsPath);
        }

        // 'factory:done' called after all factory operations have completed.
        $this->hookPoint('constructed', [ $this ]);
    }

    public function getVersion()
    {
        return '2.0.0-beta';
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
     * @example
     * <?php
     * codex()->projects->get('codex')->documents->get('index')->render();
     */
    public function error($title, $text, $code = 500, $goBack = true)
    {
        return response(view($this->view('error'), compact('title', 'text', 'goBack'))->render(), $code);
    }

    /**
     * Shorthand helper method for getting projects, refs or documents
     *
     * <strong>Example:</strong>
     * <code>
     * <?php
     * $projects    = codex()->get('*'); # Codex\Projects\Projects
     * $project     = codex()->get('codex'); # Codex\Projects\Project
     * $project     = codex()->get('codex/master'); # Codex\Projects\Project
     * $refs        = codex()->get('codex/*'); # Codex\Projects\Refs
     * $ref         = codex()->get('codex/!'); # Codex\Projects\Ref (default ref)
     * $ref         = codex()->get('codex/master'); # Codex\Projects\Ref
     * $ref         = codex()->get('codex/1.0.0'); # Codex\Projects\Ref
     * $documents   = codex()->get('codex::index); # Codex\Documents\Document (from default ref)
     * $documents   = codex()->get('codex/master::*'); # Codex\Documents\Documents
     * $document    = codex()->get('codex/master::!'); # Codex\Documents\Document (default document)
     * $document    = codex()->get('codex/master::index'); # Codex\Documents\Document
     * $document    = codex()->get('codex/master::develop/hooks'); # Codex\Documents\Document
     * </code>
     *
     *
     * @param $query
     *
     * @return \Codex\Documents\Document|\Codex\Documents\Documents|\Codex\Projects\Project|\Codex\Projects\Projects
     * @throws \Codex\Exception\CodexException
     * @example
     * <?php
     * $projects    = codex()->get('*'); # Codex\Projects\Projects
     * $project     = codex()->get('codex'); # Codex\Projects\Project
     * $project     = codex()->get('codex/master'); # Codex\Projects\Project
     * $refs        = codex()->get('codex/*'); # Codex\Projects\Refs
     * $ref         = codex()->get('codex/!'); # Codex\Projects\Ref (default ref)
     * $ref         = codex()->get('codex/master'); # Codex\Projects\Ref
     * $ref         = codex()->get('codex/1.0.0'); # Codex\Projects\Ref
     * $documents   = codex()->get('codex::index); # Codex\Documents\Document (from default ref)
     * $documents   = codex()->get('codex/master::*'); # Codex\Documents\Documents
     * $document    = codex()->get('codex/master::!'); # Codex\Documents\Document (default document)
     * $document    = codex()->get('codex::!'); # Codex\Documents\Document (from default ref, default document)
     * $document    = codex()->get('codex/master::index'); # Codex\Documents\Document
     * $document    = codex()->get('codex/master::develop/hooks'); # Codex\Documents\Document
     */
    public function get($query)
    {
        // project/ref::path/to/document

        $segments  = explode('::', $query);
        $psegments = explode('/', $segments[ 0 ]);

        $projectName      = $psegments[ 0 ];
        $projectRef       = isset($psegments[ 1 ]) ? $psegments[ 1 ] : false;
        $documentPathName = isset($segments[ 1 ]) ? $segments[ 1 ] : false;

        #
        # Projects / Project
        if ( $projectName === '*' ) {
            // get('*')
            return $this->projects;
        } elseif ( false === $this->projects->has($projectName) ) {
            throw CodexException::projectNotFound($projectName);
        }
        $project = $this->projects->get($projectName);

        #
        # Refs / Ref
        if($projectRef === false){
            if($documentPathName === false){
                // get('codex')
                return $project;
            }
            $projectRef = '!'; // make it so that the default ref will be chosen when using get('codex::path/to/document')
        }
        if($projectRef === '*'){
            // get('codex/*')
            return $project->refs;
        }
        if($projectRef === '!'){
            $ref = $project->refs->getDefault();
        } else {
            if(false === $project->refs->has($projectRef)){
                throw CodexException::refNotFound($projectRef);
            }
            $ref = $project->refs->get($projectRef);
        }
        if($documentPathName === false){
            // get('codex/!')
            // get('codex/ref')
            return $ref;
        }

        #
        # Documents / Document
        if ( $documentPathName === '*' ) {
            return $ref->documents;
        } elseif($documentPathName === '!'){
            $documentPathName = $project->config('index');
        } elseif ( false === $ref->documents->has($documentPathName) ) {
            throw CodexException::documentNotFound($documentPathName);
        }

        return $ref->documents->get($documentPathName);
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
     * @deprecated
     * @param string     $stackName The name of the stack
     * @param string     $viewName  The namespaced name of the view
     * @param array|null $data      (optional) The view data array
     * @param string     $appendTo  (optional) The view to attach this to
     *
     * @return Codex
     */
    public function pushToStack($stackName, $viewName, $data = null, $appendTo = 'codex::layouts.default')
    {
        $this->theme->pushToStack($stackName, $viewName, $data, $appendTo);
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

            $ref = $ref === null ? $project->refs->getDefaultName() : $ref;
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
     *
     * @return static
     */
    public function log($level, $message, $context = [ ])
    {
        $this->log->log($level, $message, $context);
        return $this;
    }

    /**
     * The path to the directory where all documentation projects reside
     *
     * @return string
     */
    public function getDocsPath()
    {
        return $this->docsPath;
    }

    public function getCachedLastModified($key, $lastModified, \Closure $create)
    {
        /** @var \Illuminate\Contracts\Cache\Repository $cache */
        $cache = app('cache')->driver('file');
        $clm   = (int)$cache->get($key . '.lastModified', 0);
        $plm   = (int)$lastModified;
        if ( $clm !== $plm ) {
            $cache->forever($key, $create());
            $cache->forever($key . '.lastModified', $plm);
        }
        return $cache->get($key);
    }

    public function isDev()
    {
        return $this->config('codex.dev', false) !== false;
    }

    public function setConfig($key, $value = null)
    {
        config()->set("codex.{$key}", $value);
        return $this;
    }

    public function config($key = null, $default = null)
    {
        if ( $key === null ) {
            return new Collection($this->app[ 'config' ][ 'codex' ]);
        }
        return $this->app[ 'config' ]->get("codex.{$key}", $default);
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
        if ( in_array($name, [ 'addons', 'dev' ], true) ) {
            return $this->container->make('codex.' . $name);
        }
        return parent::__get($name);
    }


}
