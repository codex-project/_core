<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core;

use Codex\Core\Contracts\Factory as FactoryContract;
use Codex\Core\Contracts\Log;
use Codex\Core\Contracts\Menus\MenuFactory;
use Codex\Core\Traits\Hookable;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Sebwite\Support\Path;
use Symfony\Component\Finder\Finder;

/**
 * Factory class.
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class Factory implements FactoryContract
{
    use Hookable;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * The codex configuration
     *
     * @var array
     */
    protected $config;

    /**
     * The filesystem instance
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Path to the directory containing all docs
     *
     * @var string
     */
    protected $rootDir;

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var \Codex\Core\Menus\MenuFactory
     */
    protected $menus;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $projects;

    /**
     * @var \Codex\Core\Contracts\Log
     */
    protected $log;


    /**
     * @param \Illuminate\Contracts\Container\Container   $container
     * @param \Illuminate\Contracts\Filesystem\Filesystem $files
     * @param \Illuminate\Contracts\Config\Repository     $config
     * @param \Illuminate\Contracts\Cache\Repository      $cache
     * @param \Codex\Core\Contracts\Log                   $log
     * @param \Codex\Core\Contracts\Menus\MenuFactory     $menus The menu factory
     */
    public function __construct(Container $container, Filesystem $files, Repository $config, Cache $cache, Log $log, MenuFactory $menus)
    {
        $this->container = $container;
        $this->cache     = $cache;
        $this->config    = $config->get('codex');
        $this->files     = $files;
        $this->rootDir   = config('codex.root_dir');
        $this->menus     = $menus;
        $this->log       = $log;
        $this->projects  = new Collection();

        // 'factory:ready' is called after parameters have been set as class properties.
        $this->runHook('factory:ready', [ $this ]);

        $this->resolveProjects();

        // 'factory:done' called after all factory operations have completed.
        $this->runHook('factory:done', [ $this ]);
    }

    /**
     * resolveProjects
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function resolveProjects()
    {
        if ( ! $this->projects->isEmpty() )
        {
            return;
        }

        /**
         * @var \Codex\Core\Menus\Node $projectsMenu
         */
        $projectsMenu = $this->menus->add('projects_menu');
        $finder       = new Finder();
        $projects     = $finder->in($this->rootDir)->files()->name('config.php')->depth('<= 1')->followLinks();

        foreach ( $projects as $projectDir )
        {
            /** @var \SplFileInfo $projectDir */
            $name    = Path::getDirectoryName($projectDir->getPath());
            $config  = $this->container->make('fs')->getRequire($projectDir->getRealPath());
            $config  = array_replace_recursive($this->config('default_project_config'), $config);
            $project = $this->container->make(Project::class, [
                'factory' => $this,
                'name'    => $name,
                'config'  => $config
            ]);

            $this->runHook('project:make', [ $this, $project ]);

            $this->projects->put($name, $project);
            $projectsMenu->add($name, $name, 'root', [ ], [
                'href' => $this->url($project)
            ]);
        }
    }


    # Projects

    /**
     * project
     *
     * @param $name
     *
*@return \Codex\Core\Project
     */
    public function getProject($name)
    {
        if ( ! $this->hasProject($name) )
        {
            throw new \InvalidArgumentException("Project [$name] could not be found in [{$this->rootDir}]");
        }

        return $this->projects->get($name);
    }

    /**
     * Check if the given project exists.
     *
     * @param  string $name
     * @return bool
     */
    public function hasProject($name)
    {
        return $this->projects->has($name);
    }

    /**
     * Return all found projects.
     *
     * @return Project[]
     */
    public function getProjects()
    {
        return $this->projects->all();
    }

    # Config

    /**
     * Retreive codex config using a dot notated key.
     *
     * @param  null|string $key
     * @param  null|string $default
     * @return array|mixed
     */
    public function config($key = null, $default = null)
    {
        if ( is_null($key) )
        {
            return $this->config;
        }

        return array_get($this->config, $key, $default);
    }

    /**
     * Get config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the config.
     *
     * @param  array $config
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }


    # Helper functions

    /**
     * Generate a URL to a project's default page and version.
     *
     * @param  Project|string $project A Project instance or projectName, will auto-resolve
     * @param  null|string    $ref
     * @param  null|string    $doc
     * @return string
     */
    public function url($project = null, $ref = null, $doc = null)
    {
        $uri = $this->config('base_route');

        if ( ! is_null($project) )
        {
            if ( ! $project instanceof Project )
            {
                $project = $this->getProject($project);
            }
            $uri .= '/' . $project->getName();


            if ( ! is_null($ref) )
            {
                $uri .= '/' . $ref;
            }
            else
            {
                $uri .= '/' . $project->getDefaultRef();
            }


            if ( ! is_null($doc) )
            {
                $uri .= '/' . $doc;
            }
        }

        return url($uri);
    }

    /**
     * log method
     *
     * @param       $level
     * @param       $message
     * @param array $context
     */
    public function log($level, $message, $context = [])
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
     * Get files.
     *
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set files.
     *
     * @param  mixed $files
     * @return Factory
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
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
     * @return Factory
     */
    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * get app value
     *
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getApp()
    {
        return $this->container;
    }

    /**
     * Set the app value
     *
     * @param \Illuminate\Contracts\Container\Container $app
     * @return Factory
     */
    public function setApp($app)
    {
        $this->container = $app;

        return $this;
    }

    /**
     * get menus value
     *
     * @return Menus\MenuFactory
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Set the menus value
     *
     * @param Menus\MenuFactory $menus
     * @return Factory
     */
    public function setMenus($menus)
    {
        $this->menus = $menus;

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
     * @return Factory
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }


}
