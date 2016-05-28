<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Projects;


use Codex\Core\Contracts;
use Codex\Core\Traits;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Filesystem\FilesystemManager;
use Sebwite\Support\Str;
use Symfony\Component\Yaml\Yaml;
use vierbergenlars\SemVer\version;

/**
 * This is the class Project.
 *
 * @package        Codex\Core
 * @author         Robin Radic
 * @copyright      Copyright (c) 2015, Robin Radic. All rights reserved
 *
 * @property \Codex\Core\Documents\Documents $documents
 * @property \Codex\Core\Documents\Documents $documents2
 * @property \Codex\Addon\Defaults\Phpdoc\PhpdocDocument $getPhpdoc
 *
 */
class Project implements
    Contracts\Extendable,
    Contracts\Hookable,
    Contracts\Bootable,
    Arrayable
{
    use Traits\ExtendableTrait,
        Traits\HookableTrait,
        Traits\ObservableTrait,
        Traits\BootableTrait,

        Traits\CodexTrait,
        Traits\FilesTrait,
        Traits\ConfigTrait;


    const SHOW_MASTER_BRANCH = 0;
    const SHOW_LAST_VERSION = 1;
    const SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH = 2;
    const SHOW_CUSTOM = 3;

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

    protected $projects;

    protected $diskName;

    /**
     * Project constructor.
     *
     * @param \Codex\Core\Projects\Projects                 $projects
     * @param \Codex\Core\Contracts\Codex|\Codex\Core\Codex $codex
     * @param \Illuminate\Filesystem\FilesystemManager      $fsm
     * @param \Illuminate\Contracts\Config\Repository       $repository
     * @param \Illuminate\Contracts\Container\Container     $container
     * @param                                               $name
     * @param                                               $config
     */
    public function __construct(Contracts\Codex $codex, FilesystemManager $fsm, Repository $repository, Container $container, Projects $projects, $name, $config)
    {
        $this->setCodex($codex);
        $this->fsm        = $fsm;
        $this->repository = $repository;
        $this->projects   = $projects;
        $this->name       = $name;
        $this->setConfig($config);
        $this->path = $path = path_join($codex->getDocsDir(), $name);

        $this->hookPoint('project:construct');

        $this->diskName = $this->getDefaultDiskName();
        $this->setDisk();
        $this->resolveRefs();

        # Resolve menu
        $this->hookPoint('project:constructed');
    }

    public function setActive()
    {
        $this->projects->setActive($this);
        return $this;
    }

    public function isActive()
    {
        return $this->projects->getActive() === $this;
    }

    public function getDefaultDiskName()
    {
        return 'codex-local-' . $this->getName();
    }

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
     * setDisk method
     *
     * @param null|string $diskName
     *
     */
    public function setDisk()
    {
        $this->repository->set(
            "filesystems.disks.{$this->getDiskName()}",
            $this->getDiskConfig()->toArray()
        );
        $this->setFiles($this->fsm->disk($this->getDiskName()));
    }

    public function getDiskName()
    {
        return $this->diskName ?: $this->getDefaultDiskName();
    }

    public function getDiskConfig()
    {
        $default = [ ];
        if ( $this->getDiskName() === $this->getDefaultDiskName() ) {
            $default = [
                'driver' => 'codex-local',
                'root'   => $this->codex->getDocsDir() . DIRECTORY_SEPARATOR . $this->getName(),
            ];
        }

        return collect($this->repository->get("filesystems.disks.{$this->getDiskName()}", $default));
    }

    protected function resolveRefs()
    {

        $directories = $this->getFiles()->directories();
        $branches    = [ ];
        $this->refs  = [ ];

        $this->versions = array_filter(array_map(function ($dirPath) use (&$branches) {
            $version      = Str::create(Str::ensureLeft($dirPath, '/'))->removeLeft(DIRECTORY_SEPARATOR);
            $version      = (string)$version->removeLeft($this->name . '/');
            $this->refs[] = $version;

            try {
                return new version($version);
            }
            catch (\RuntimeException $e) {
                $branches[] = $version;
            }
        }, $directories), 'is_object');

        $this->branches = $branches;

        // check which version/branch to show by default
        $defaultRef = count($this->versions) > 0 ? head($this->versions) : head($branches);

        switch ( $this->config[ 'default' ] ) {
            case static::SHOW_LAST_VERSION:
                usort($this->versions, function (version $v1, version $v2) {


                    return version::gt($v1, $v2) ? -1 : 1;
                });

                $defaultRef = head($this->versions);
                break;
            case static::SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH:
                if ( count($this->versions) > 0 ) {
                    usort($this->versions, function (version $v1, version $v2) {


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

    public function getDisk()
    {
        return $this->fsm->disk($this->getDiskName());
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
        $root = $this->getDiskConfig()->get('root');
        $path = isset($path) ? $root : path_join($root, $path);
        return path_absolute($root, $path);
        #return is_null($path) ? '' : path_absolute($path, $this->rootPath());
        #return is_null($path) ? $root : path_join($root, $path);
    }

    public function rootPath($path = null)
    {
        $root = $this->getDiskConfig()->get('root');
        $path = isset($path) ? $root : path_join($root, $path);
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

    /**
     * Returns the menu for this project
     *
     * @return \Codex\Core\Menus\Menu
     */
    public function getSidebarMenu()
    {
        return $this->getCodex()->menus->get('sidebar');
        $path  = $this->refPath('menu.yml');
        $yaml  = $this->getFiles()->get($path);
        $array = Yaml::parse($yaml);


        $menu = $this->setupSidebarMenu($array[ 'menu' ]);
        $this->hookPoint('project:documents-menu', [ $this, $menu ]);

        return $menu;
    }

    public function refPath($path = null)
    {
        return path_join($this->getRef(), $path);
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
         * @var \Codex\Core\Menus\Menu $menu
         */
        $menu = $this->codex->menus->add('sidebar');

        foreach ( $items as $item ) {
            $link = '#';
            if ( array_key_exists('document', $item) ) {
                // remove .md extension if present
                $path = Str::endsWith($item[ 'document' ], '.md', false) ? Str::remove($item[ 'document' ], '.md') : $item[ 'document' ];
                $link = $this->codex->url($this, $this->getRef(), $path);
            } elseif ( array_key_exists('href', $item) ) {
                $link = $item[ 'href' ];
            }

            $id = md5($item[ 'name' ] . $link);

            $node = $menu->add($id, $item[ 'name' ], $parentId);
            $node->setAttribute('href', $link);
            $node->setAttribute('id', $id);

            if ( isset($item[ 'icon' ]) ) {
                $node->setMeta('icon', $item[ 'icon' ]);
            }

            if ( isset($item[ 'children' ]) ) {
                $this->setupSidebarMenu($item[ 'children' ], $id);
            }
        }

        return $menu;
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


    # Getters / setters

    /**
     * Get refs sorted by the configured order.
     *
     * @return array
     */
    public function getSortedRefs()
    {
        $versions = $this->versions;


        usort($versions, function (version $v1, version $v2) {


            return version::gt($v1, $v2) ? -1 : 1;
        });

        $versions = array_map(function (version $v) {


            return $v->getVersion();
        }, $versions);

        return array_merge($this->branches, $versions);
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
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'     => $this->getName(),
            'config'   => $this->getConfig(),
            'versions' => $this->refs,
        ];
    }

    /**
     * getConfig method
     * @return \Codex\Core\Projects\ProjectConfig
     */
    public function getConfig()
    {
        return $this->getContainer()->make(ProjectConfig::class, [ 'config' => $this->config ]);
    }

    /**
     * getDisplayName method
     * @return string
     */
    public function getDisplayName()
    {
        return $this->config('display_name', $this->getName());
    }
}
