<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core;

use Codex\Core\Contracts\Codex;
use Codex\Core\Traits;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\FilesystemManager;
use Sebwite\Support\Path;
use Sebwite\Support\Str;
use Sebwite\Support\Traits\Extendable;
use Symfony\Component\Yaml\Yaml;
use vierbergenlars\SemVer\version;

/**
 * This is the class Project.
 *
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 *
 *
 * @property \Codex\Core\Components\Project\Documents $documents
 */
class Project
{
    use Extendable,
        Traits\Hookable,
        Traits\FilesTrait,
        Traits\ConfigTrait,
        Traits\CodexTrait;

    const SHOW_MASTER_BRANCH                        = 0;
    const SHOW_LAST_VERSION                         = 1;
    const SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH = 2;
    const SHOW_CUSTOM                               = 3;

    /**
     * A collection of branches in this project
     *
     * @var array
     */
    protected $branches;

    /**
     * The default ref/version/branch for this project
     *
     * @var string
     */
    protected $defaultRef;

    /**
     * The name of the project
     *
     * @var string
     */
    protected $name;

    /**
     * The absolute path to this project
     *
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $ref;

    /**
     * @var array
     */
    protected $refs;

    /**
     * @var array
     */
    protected $versions;

    protected $repository;

    protected $fsm;

    /**
     * getContainer method
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->getCodex()->getContainer();
    }

    /**
     * Project constructor.
     *
     * @param \Codex\Core\Contracts\Codex|\Codex\Core\Components\Factory\ $parent
     * @param \Illuminate\Filesystem\FilesystemManager                    $fsm
     * @param \Illuminate\Contracts\Config\Repository                     $repository
     * @param \Illuminate\Contracts\Container\Container                   $container
     * @param                                                             $name
     * @param                                                             $config
     */
    public function __construct(Codex $parent, FilesystemManager $fsm, Repository $repository, Container $container, $name, $config)
    {
        $this->setCodex($parent);
        $this->name       = $name;
        $this->path       = $path = Path::join($parent->getRootDir(), $name);
        $this->fsm        = $fsm;
        $this->repository = $repository;
        $this->setConfig($config);
        $this->setDisk([
            'driver' => 'local',
            'root'   => Path::join($this->getCodex()->getRootDir(), $this->getName())
        ]);
        $this->runHook('project:ready', [ $this ]);

        # Resolve refs
        $this->resolveRefs();

        # Resolve menu
        $this->runHook('project:done', [ $this ]);
    }


    public function getDiskName()
    {
        return 'codex-' . $this->getName();
    }

    public function setDisk(array $config = [ ])
    {
        $this->repository->set('filesystems.disks.' . $this->getDiskName(), $config);
        $files = $this->fsm->disk($this->getDiskName());
        $this->setFiles($files);
    }

    public function getDisk()
    {
        return collect($this->repository->get('filesystems.disks.' . $this->getDiskName()));
    }

    /**
     * Get the absolute path to a file in the project using the current ref
     *
     * @param null|string $path
     *
     * @return string
     */
    public function path($path = null)
    {
        $root     = $this->getDisk()->get('root');
        $absolute = is_null($path) ? $this->path : Path::join($this->path, $path);
        $relative = path_relative($absolute, $root);

        return $relative;
    }

    public function refPath($path = null)
    {
        return is_null($path) ? $this->path($this->ref) : $this->path(path_join($this->ref, $path));
    }

    /**
     * Generate a URL to the specified document. A shorthand for the factory's url method
     *
     * @param string      $doc
     * @param null|string $ref
     *
     * @return string
     */
    public function url($doc = 'index', $ref = null)
    {
        return $this->codex->url($this, $ref, $doc);
    }

    public function hasEnabledFilter($filter)
    {
        return in_array($filter, $this->config('filters.enabled', [ ]), true);
    }

    public function hasEnabledHook($hook)
    {
        return in_array($hook, $this->config('hooks.enabled', [ ]), true);
    }

    protected function resolveRefs()
    {

        $directories = $this->getFiles()->directories();
        $branches    = [ ];
        $this->refs  = [ ];

        $this->versions = array_filter(array_map(function ($dirPath) use (&$branches)
        {

            $version      = Str::create(Str::ensureLeft($dirPath, '/'))->removeLeft(DIRECTORY_SEPARATOR);
            $version      = (string)$version->removeLeft($this->name . '/');
            $this->refs[] = $version;

            try
            {
                return new version($version);
            }
            catch (\RuntimeException $e)
            {
                $branches[] = $version;
            }
        }, $directories), 'is_object');

        $this->branches = $branches;

        // check which version/branch to show by default
        $defaultRef = count($this->versions) > 0 ? head($this->versions) : head($branches);

        switch ( $this->config[ 'default' ] )
        {
            case static::SHOW_LAST_VERSION:
                usort($this->versions, function (version $v1, version $v2)
                {


                    return version::gt($v1, $v2) ? -1 : 1;
                });

                $defaultRef = head($this->versions);
                break;
            case static::SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH:
                if ( count($this->versions) > 0 )
                {
                    usort($this->versions, function (version $v1, version $v2)
                    {


                        return version::gt($v1, $v2) ? -1 : 1;
                    });
                }

                $defaultRef = count($this->versions) > 0 ? head($this->versions) : head($branches);
                break;
            case static::SHOW_MASTER_BRANCH:
                $defaultRef = 'master';
                break;
            case Project::SHOW_CUSTOM:
                $defaultRef = $this->config[ 'custom' ];
                break;
        }

        $this->ref = $this->defaultRef = (string)$defaultRef;
    }

    /**
     * Returns the menu for this project
     *
     * @return \Codex\Core\Menu
     */
    public function getSidebarMenu()
    {

        $path  = $this->refPath('menu.yml');
        $yaml  = $this->getFiles()->get($path);
        $array = Yaml::parse($yaml);
        $this->getCodex()->menus->forget('sidebar');

        $menu = $this->setupSidebarMenu($array[ 'menu' ]);
        $this->runHook('project:documents-menu', [ $this, $menu ]);

        return $menu;
    }

    /**
     * Resolves and creates the documents menu from the parsed menu.yml
     *
     * @param array  $items The array converted from yaml
     * @param string $parentId
     *
     * @return \Codex\Core\Menu
     */
    protected function setupSidebarMenu($items, $parentId = 'root')
    {
        /**
         * @var Codex\Core\Menu $menu
         */
        $menu = $this->codex->menus->add('sidebar');

        foreach ( $items as $item )
        {
            $link = '#';
            if ( array_key_exists('document', $item) )
            {
                // remove .md extension if present
                $path = Str::endsWith($item[ 'document' ], '.md', false) ? Str::remove($item[ 'document' ], '.md') : $item[ 'document' ];
                $link = $this->codex->url($this, $this->getRef(), $path);
            }
            elseif ( array_key_exists('href', $item) )
            {
                $link = $item[ 'href' ];
            }

            $id = md5($item[ 'name' ] . $link);

            $node = $menu->add($id, $item[ 'name' ], $parentId);
            $node->setAttribute('href', $link);
            $node->setAttribute('id', $id);

            if ( isset($item[ 'icon' ]) )
            {
                $node->setMeta('icon', $item[ 'icon' ]);
            }

            if ( isset($item[ 'children' ]) )
            {
                $this->setupSidebarMenu($item[ 'children' ], $id);
            }
        }

        return $menu;
    }

    /**
     * Set the ref (version/branch) you want to use. getDocument will be getting stuff using the ref
     *
     * @param  string $name
     *
     * @return \Codex\Core\Project
     */
    public function setRef($name)
    {
        $this->ref = $name;

        return $this;
    }

    /**
     * Get ref.
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Get default ref.
     *
     * @return string
     */
    public function getDefaultRef()
    {
        return $this->defaultRef;
    }

    /**
     * Get refs.
     *
     * @return array
     */
    public function getRefs()
    {
        return $this->refs;
    }

    /**
     * Get refs sorted by the configured order.
     *
     * @return array
     */
    public function getSortedRefs()
    {
        $versions = $this->versions;

        usort($versions, function (version $v1, version $v2)
        {


            return version::gt($v1, $v2) ? -1 : 1;
        });

        $versions = array_map(function (version $v)
        {


            return $v->getVersion();
        }, $versions);

        return array_merge($this->branches, $versions);
    }


    # Getters / setters


    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get branches.
     *
     * @return array
     */
    public function getBranches()
    {
        return $this->branches;
    }

    /**
     * Get versions.
     *
     * @return array
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * Set path.
     *
     * @param  string $path
     *
     * @return \Codex\Core\Project
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}
