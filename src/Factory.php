<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core;

use Codex\Core\Contracts\Codex;
use Codex\Core\Contracts\Log;
use Codex\Core\Contracts\Menus\MenuFactory;
use Codex\Core\Traits;
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
class Factory implements Codex
{
    use Traits\Hookable, Traits\ConfigTrait, Traits\FilesTrait, Traits\ContainerTrait;

    /**
     * The codex menu factory instance
     *
     * @var \Codex\Core\Menus\MenuFactory
     */
    protected $menus;

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

    /**
     * A collection of resolved projects
     *
     * @var \Illuminate\Support\Collection
     */
    protected $projects;

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
        $this->setContainer($container);
        $this->setConfig($config->get('codex'));
        $this->setFiles($files);
        $this->cache     = $cache;
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

    # Projects

    /**
     * Scans the configured documentation root directory for projects and resolves them and puts them into the projects collection
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function resolveProjects()
    {
        if (!$this->projects->isEmpty()) {
            return;
        }

        /**
         * @var \Codex\Core\Menus\Node $projectsMenu
         */
        $projectsMenu = $this->menus->add('projects_menu');
        $finder       = new Finder();
        $projects     = $finder->in($this->rootDir)->files()->name('config.php')->depth('<= 1')->followLinks();

        foreach ($projects as $projectDir) {
        /** @var \SplFileInfo $projectDir */
            $name    = Path::getDirectoryName($projectDir->getPath());
            $config  = $this->container->make('fs')->getRequire($projectDir->getRealPath());
            $config  = array_replace_recursive($this->config('default_project_config'), $config);
            $project = $this->container->make(Project::class, [
                'codex'  => $this,
                'name'   => $name,
                'config' => $config
            ]);

            $this->runHook('project:make', [ $this, $project ]);

            $this->projects->put($name, $project);
            $projectsMenu->add($name, $name, 'root', [ ], [
                'href' => $this->url($project)
            ]);
        }
    }

    /**
     * Returns a project instance for the given name
     *
     * @param $name
     *
     * @return \Codex\Core\Project
     */
    public function getProject($name)
    {
        if (!$this->hasProject($name)) {
            throw new \InvalidArgumentException("Project [$name] could not be found in [{$this->rootDir}]");
        }

        return $this->projects->get($name);
    }

    /**
     * Check if the given project exists.
     *
     * @param  string $name
     *
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

        if (!is_null($project)) {
            if (!$project instanceof Project) {
                $project = $this->getProject($project);
            }
            $uri .= '/' . $project->getName();


            if (!is_null($ref)) {
                $uri .= '/' . $ref;
            } else {
                $uri .= '/' . $project->getDefaultRef();
            }


            if (!is_null($doc)) {
                $uri .= '/' . $doc;
            }
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
     *
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
     *
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
     *
     * @return Factory
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }
}
