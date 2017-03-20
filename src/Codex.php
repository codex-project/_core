<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex;

use Codex\Contracts;
use Codex\Exception\CodexException;
use Codex\Exception\DocumentNotFoundException;
use Codex\Exception\ProjectNotFoundException;
use Codex\Exception\RefNotFoundException;
use Codex\Projects\Project;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Support\Traits;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * This is the main Codex class. Exposes several extensions and helper functions.
 *
 * @package        Codex\Core
 * @author         Robin Radic
 *
 *
 * @copyright      Copyright (c) 2015, Codex Project. All rights reserved
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

    /**
     *
     */
    const SHOW_MASTER_BRANCH = 0;
    /**
     *
     */
    const SHOW_LAST_VERSION = 1;
    /**
     *
     */
    const SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH = 2;
    /**
     *
     */
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

    protected $projects;

    /**
     * A collection of resolved extensions
     *
     * @var Collection
     */
    protected static $resolved;

    /**
     * Adds $extension to a "Codex\Support\Extendable" class.
     *
     * @see \Codex\Support\Extendable
     *
     * @param string          $class     The target class to for the extension
     * @param string          $name      The name of the extension. Serves as method/property name on the target class
     * @param \Closure|string $extension The extension, can be a class reference, class-method reference or a closure
     */
    public static function registerExtension($class, $name, $extension)
    {
        if (null === static::$resolved) {
            static::$resolved = new Collection();
        }
        \Illuminate\Container\Container::getInstance()->resolving($class, function ($instance) use ($name, $extension) {
            $className  = get_class($instance);
            $isExtended = static::$resolved->where('className', $className)->where('name', $name)->count() > 0;
            if ($isExtended) {
                return;
            }
            static::$resolved->push(compact('className', 'name'));
            forward_static_call_array($className . '::extend', [ $name, $extension ]);
        });
    }

    /**
     * Codex constructor.
     *
     * **Example**
     * ```php
     * codex()->projects->get('codex')->documents->get('index')->render();
     * ```
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


        // 'factory:done' called after all factory operations have completed.
        $this->hookPoint('constructed', [ $this ]);
    }

    public function getProjects()
    {
        if (null === $this->projects) {
            $this->projects = [];
            $finder         = new Finder();
            $projects       = $finder
                ->in($this->getDocsPath())
                ->files()
                ->name('config.php')
                ->depth('<= 1')
                ->followLinks();
            foreach ($projects as $projectDir) {
                /** @var \SplFileInfo $projectDir */
                $name                    = path_get_directory_name($projectDir->getPath());
                $config                  = $this->container->make('fs')->getRequire($projectDir->getRealPath());
                $config                  = array_replace_recursive(config('codex.projects.default_config'), $config);
                $this->projects[ $name ] = $config;
            }
        }
        return $this->projects;
    }

    public function getProject($name)
    {
        $this->getProjects();
        if (!array_key_exists($name, $this->projects)) {
            throw CodexException::projectNotFound($name);
        }
        if (!$this->projects[ $name ] instanceof Project) {
            $this->projects[ $name ] = $this->container->make('codex.project', [
                'name'   => $name,
                'config' => $this->projects[ $name ],
            ]);
        }
        return $this->projects[ $name ];
    }

    /**
     * Shorthand method for getting projects, refs or documents
     *
     * **Syntax:**
     * {project?}/{$ref?}::{documentPath?}
     *
     * **Modifiers:**
     * * = The collection (projects, refs or documents)
     * ! = The default of the collection (project, def or document)
     *
     * **Syntax examples:**
     * `codex/master::getting-started/installation`
     *
     * ```php
     * $projects    = codex()->get('*'); # Codex\Projects\Projects
     * $project     = codex()->get('!'); # Codex\Projects\Project (default)
     * $project     = codex()->get('codex'); # Codex\Projects\Project
     * $refs        = codex()->get('codex/*'); # Codex\Projects\Refs
     * $ref         = codex()->get('codex/!'); # Codex\Projects\Ref (default ref)
     * $ref         = codex()->get('codex/master'); # Codex\Projects\Ref
     * $ref         = codex()->get('codex/1.0.0'); # Codex\Projects\Ref
     * $documents   = codex()->get('codex::index); # Codex\Documents\Document (from default ref)
     * $documents   = codex()->get('codex/master::*'); # Codex\Documents\Documents
     * $document    = codex()->get('codex/master::!'); # Codex\Documents\Document (default document)
     * $document    = codex()->get('codex/master::index'); # Codex\Documents\Document
     * $document    = codex()->get('codex/master::develop/hooks'); # Codex\Documents\Document
     * ```
     *
     * @param string $query The query to run
     *
     * @return \Codex\Documents\Document|\Codex\Documents\Documents|\Codex\Projects\Project|\Codex\Projects\Projects|\Codex\Projects\Ref|\Codex\Projects\Refs
     * @throws \Codex\Exception\DocumentNotFoundException
     * @throws \Codex\Exception\ProjectNotFoundException
     * @throws \Codex\Exception\RefNotFoundException
     * @example
     * <?php
     * $projects    = codex()->get('*'); # Codex\Projects\Projects
     * $project     = codex()->get('codex'); # Codex\Projects\Project
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
     *
     */
    public function get($query)
    {
        // project/ref::path/to/document

        $segments  = explode('::', $query);
        $psegments = explode('/', $segments[ 0 ]);

        $projectName      = $psegments[ 0 ];
        $projectRef       = isset($psegments[ 1 ]) ? $psegments[ 1 ] : false;
        $documentPathName = isset($segments[ 1 ]) ? $segments[ 1 ] : false;

        # Projects / Project
        if ($projectName === '*') {
            // get('*')
            return $this->projects;
        } elseif ($projectName === '!') {
            $projectName = config('codex.default_project');
        }

        if (false === $this->projects->has($projectName)) {
            throw ProjectNotFoundException::project($projectName);
        }
        $project = $this->projects->get($projectName);

        # Refs / Ref
        if ($projectRef === false) {
            if ($documentPathName === false) {
                // get('codex')
                return $project;
            }
            $projectRef = '!'; // make it so that the default ref will be chosen when using get('codex::path/to/document')
        }
        if ($projectRef === '*') {
            return $project->refs;
        }
        if ($projectRef === '!') {
            $ref = $project->refs->getDefault();
        } else {
            if (false === $project->refs->has($projectRef)) {
                throw RefNotFoundException::ref($projectRef);
            }
            $ref = $project->refs->get($projectRef);
        }
        if ($documentPathName === false) {
            return $ref;
        }

        # Documents / Document
        if ($documentPathName === '*') {
            return $ref->documents;
        } elseif ($documentPathName === '!') {
            $documentPathName = $project->config('index');
        } elseif (false === $ref->documents->has($documentPathName)) {
            throw DocumentNotFoundException::document($documentPathName);
        }

        return $ref->documents->get($documentPathName);
    }

    /**
     * Get or set a Codex view
     *
     * @param string        $name The simple name
     *
     * @param null | string $view If given, this view will be set
     *
     * @return string The namespaced view name
     */
    public function view($name, $view = null)
    {
        return $view ? $this->addons->views->set($name, $view) : $this->addons->views->get($name);
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
        return route('codex.document', [ 'projectSlug' => $project, 'ref' => $ref, 'document' => $doc ]);
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
    public function log($level, $message, $context = [])
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
        $docsPath = config('codex.paths.docs');
        if (path_is_relative($docsPath)) {
            $docsPath = base_path($docsPath);
        }
        return $docsPath;
    }

    /**
     * getCachedLastModified method
     *
     * @param          $key
     * @param          $lastModified
     * @param \Closure $create
     *
     * @return mixed
     */
    public function getCachedLastModified($key, $lastModified, \Closure $create)
    {
        /** @var \Illuminate\Contracts\Cache\Repository $cache */
        $cache = app('cache')->driver('file');
        $clm   = (int)$cache->get($key . '.lastModified', 0);
        $plm   = (int)$lastModified;
        if ($clm !== $plm) {
            $cache->forever($key, $create());
            $cache->forever($key . '.lastModified', $plm);
        }
        return $cache->get($key);
    }

    /**
     * Sets a config value
     *
     * @param      $key
     * @param null $value
     *
     * @return $this
     */
    public function setConfig($key, $value = null)
    {
        config()->set("codex.{$key}", $value);
        return $this;
    }

    /**
     * Get a config value
     *
     * @param null $key
     * @param null $default
     *
     * @return \Codex\Support\Collection
     */
    public function config($key = null, $default = null)
    {
        if ($key === null) {
            return new Collection($this->app[ 'config' ][ 'codex' ]);
        }
        return $this->app[ 'config' ]->get("codex.{$key}", $default);
    }

    /**
     * Get cache instance
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
     * getLog method
     *
     * @return \Codex\Contracts\Log\Log
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * setLog method
     *
     * @param $log
     *
     * @return $this
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * toArray method
     *
     * @return array
     */
    public function toArray()
    {
        $projects = $this->projects->getItems();
        if ($this->projects->isEmpty()) {
        }
        return [
            'defaultProject' => $this->config('default_project', $projects->first()->getName()),
            'projects'       => $this->projects->getItems()->map(function (\Codex\Projects\Project $project) {
                return array_add($project->toArray(), 'refs', $project->refs->toArray());
            })->toArray(),
            'menus'          => $this->menus->toArray(),
        ];
    }

    /**
     * __get method
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (in_array($name, [ 'addons', 'dev' ], true)) {
            return $this->container->make('codex.' . $name);
        }
        return parent::__get($name);
    }

    /**
     * Creates a error response. To be used in controllers/middleware
     *
     * @deprecated
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
     * isDev method
     *
     * @deprecated
     * @return bool
     */
    public function isDev()
    {
        return $this->config('codex.dev', false) !== false;
    }

    /**
     * hook method
     *
     * @param      $name
     * @param      $hook
     * @param bool $replace
     *
     * @return $this
     */
    public function hook($name, $hook, $replace = false)
    {
        $this->addons->hooks->hook($name, $hook, $replace);
        return $this;
    }
}
