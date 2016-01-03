<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */

namespace Codex\Core;

use Codex\Core\Contracts\Codex;
use Codex\Core\Traits;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Filesystem\Filesystem;
use Sebwite\Support\Path;
use Sebwite\Support\Str;
use Symfony\Component\Yaml\Yaml;
use vierbergenlars\SemVer\version;

/**
 * Project class.
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class Project
{
    use Traits\Hookable, Traits\ConfigTrait, Traits\FilesTrait, Traits\CodexTrait, Traits\ContainerTrait;

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

    /**
     * A collection of documents that have already been instantiated. getDocument method will first check if the document is here.
     *
     * @var Document[]
     */
    protected $documents = [ ];

    /**
     * The menu instance, getMenu will first check if this property is set and if so returns it.
     * Otherwise it will instanciate a new Menu and set this property
     *
     * @var \Codex\Core\Menus\Menu
     */
    protected $menu;

    /**
     * @param \Codex\Core\Factory                         $codex
     * @param \Illuminate\Contracts\Filesystem\Filesystem $files
     * @param \Illuminate\Contracts\Container\Container   $container
     * @param string                                      $name
     * @param array                                       $config
     */
    public function __construct(Codex $codex, Filesystem $files, Container $container, $name, $config)
    {
        $this->setContainer($container);
        $this->setCodex($codex);
        $this->setConfig($config);
        $this->setFiles($files);
        $this->name = $name;
        $this->path = $path = Path::join($codex->getRootDir(), $name);

        $this->runHook('project:ready', [ $this ]);

        # Resolve refs

        $directories = $this->files->directories($this->path);
        $branches    = [ ];
        $this->refs  = [ ];

        $this->versions = array_filter(array_map(function ($dirPath) use ($path, $name, &$branches) {
        


            $version      = Str::create(Str::ensureLeft($dirPath, '/'))->removeLeft($path)->removeLeft(DIRECTORY_SEPARATOR);
            $version      = (string)$version->removeLeft($name . '/');
            $this->refs[] = $version;

            try {
                return new version($version);
            } catch (\RuntimeException $e) {
                $branches[] = $version;
            }
        }, $directories), 'is_object');

        $this->branches = $branches;

        // check which version/branch to show by default
        $defaultRef = count($this->versions) > 0 ? head($this->versions) : head($branches);

        switch ($this->config[ 'default' ]) {
            case Project::SHOW_LAST_VERSION:
                usort($this->versions, function (version $v1, version $v2) {
                


                    return version::gt($v1, $v2) ? -1 : 1;
                });

                $defaultRef = head($this->versions);
                break;
            case Project::SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH:
                if (count($this->versions) > 0) {
                    usort($this->versions, function (version $v1, version $v2) {
                    


                        return version::gt($v1, $v2) ? -1 : 1;
                    });
                }

                $defaultRef = count($this->versions) > 0 ? head($this->versions) : head($branches);
                break;
            case Project::SHOW_MASTER_BRANCH:
                $defaultRef = 'master';
                break;
            case Project::SHOW_CUSTOM:
                $defaultRef = $this->config[ 'custom' ];
                break;
        }

        $this->ref = $this->defaultRef = (string)$defaultRef;

        # Resolve menu
        $this->runHook('project:done', [ $this ]);
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
        return is_null($path) ? Path::join($this->path, $this->ref) : Path::join($this->path, $this->ref, $path);
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

    /**
     * Get a document by path. Returns an instance of document
     *
     * @param string $pathName
     *
     * @return \Codex\Core\Document
     */
    public function getDocument($pathName = '')
    {
        if ($pathName === '') {
            $pathName = 'index';
        }

        if (!isset($this->documents[ $pathName ])) {
            $path = Path::join($this->path, $this->ref, $pathName . '.md');

            $this->documents[ $pathName ] = $this->container->make('codex.builder.document', [
                'factory'  => $this->codex,
                'project'  => $this,
                'path'     => $path,
                'pathName' => $pathName
            ]);
            //new Document($this->factory, $this, $this->files, $path, $pathName);

            $this->runHook('project:document', [ $this->documents[ $pathName ] ]);
        }


        return $this->documents[ $pathName ];
    }

    public function hasEnabledFilter($filter)
    {
        return in_array($filter, $this->config('filters.enabled', [ ]), true);
    }

    public function hasEnabledHook($hook)
    {
        return in_array($hook, $this->config('hooks.enabled', [ ]), true);
    }

    # Menu

    /**
     * Returns the menu for this project
     *
     * @return \Codex\Core\Menus\Menu
     */
    public function getSidebarMenu()
    {

        $path  = Path::join($this->getPath(), $this->getRef(), 'menu.yml');
        $yaml  = $this->files->get($path);
        $array = Yaml::parse($yaml);
        $this->codex->getMenus()->forget('sidebar');

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
     * @return \Codex\Core\Menus\Menu
     */
    protected function setupSidebarMenu($items, $parentId = 'root')
    {
        /**
         * @var Menus\Menu $menu
         */
        $menu = $this->getCodex()->getMenus()->add('sidebar');

        foreach ($items as $item) {
            $link = '#';
            if (array_key_exists('document', $item)) {
            // remove .md extension if present
                $path = Str::endsWith($item[ 'document' ], '.md', false) ? Str::remove($item[ 'document' ], '.md') : $item[ 'document' ];
                $link = $this->codex->url($this, $this->getRef(), $path);
            } elseif (array_key_exists('href', $item)) {
                $link = $item[ 'href' ];
            }

            $id = md5($item[ 'name' ] . $link);

            $node = $menu->add($id, $item[ 'name' ], $parentId);
            $node->setAttribute('href', $link);
            $node->setAttribute('id', $id);

            if (isset($item[ 'icon' ])) {
                $node->setMeta('icon', $item[ 'icon' ]);
            }

            if (isset($item[ 'children' ])) {
                $this->setupSidebarMenu($item[ 'children' ], $id);
            }
        }

        return $menu;
    }



    # Refs / versions

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

        usort($versions, function (version $v1, version $v2) {
        

            return version::gt($v1, $v2) ? -1 : 1;
        });

        $versions = array_map(function (version $v) {
        

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
