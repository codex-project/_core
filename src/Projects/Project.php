<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Projects;


use Codex\Codex;
use Codex\Support\Extendable;
use Codex\Support\Traits\ConfigTrait;
use Codex\Support\Traits\FilesTrait;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Filesystem\FilesystemManager;
use vierbergenlars\SemVer\version;

/**
 * This is the class Project.
 *
 * @property \Codex\Documents\Documents    $documents Get documents
 * @property \Codex\Projects\Refs          $refs
 *
 * @package        Codex\Core
 * @author         Robin Radic
 * @copyright      Copyright (c) 2015, Robin Radic. All rights reserved
 *
 * @property \Codex\Documents\Documents    $documents2
 *
 * @method boolean hasEnabledAuth()
 * @method boolean hasAccess()
 *
 *
 */
class Project extends Extendable implements Arrayable
{
    use FilesTrait,
        ConfigTrait;


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

    protected $repository;

    protected $fsm;

    protected $projects;

    protected $diskName;

    /**
     * Project constructor. Should be slim, as it gets instanciated for each project.
     *
     * @param \Codex\Projects\Projects                      $projects
     * @param \Codex\Codex                                  $codex
     * @param \Illuminate\Filesystem\FilesystemManager      $fsm
     * @param \Illuminate\Contracts\Config\Repository       $repository
     * @param \Illuminate\Contracts\Container\Container     $container
     * @param                                               $name
     * @param                                               $config
     */
    public function __construct(Codex $codex, FilesystemManager $fsm, Repository $repository, Container $container, Projects $projects, $name, $config)
    {
        $this->setCodex($codex);
        $this->fsm        = $fsm;
        $this->repository = $repository;
        $this->projects   = $projects;
        $this->name       = $name;
        $this->setConfig($config);
        $this->path = $path = path_join($codex->getDocsPath(), $name);

        $this->hookPoint('project:construct');

        $this->diskName = $this->getDefaultDiskName();
        $this->setDisk();

        # Resolve menu
        $this->hookPoint('project:constructed');
    }


    public function getDefaultDiskName()
    {
        return 'codex-local-' . $this->getName();
    }

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
                'root'   => $this->codex->getDocsPath() . DIRECTORY_SEPARATOR . $this->getName(),
            ];
        }

        return collect($this->repository->get("filesystems.disks.{$this->getDiskName()}", $default));
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

    public function hasEnabledProcessor($filter)
    {
        return in_array($filter, $this->config('processors.enabled', [ ]), true);
    }

    public function hasEnabledAddon($name)
    {
        return $this->config("{$name}.enabled", false) === true;
    }

    public function hasEnabledExtension($extension)
    {
        return in_array($extension, $this->config('extensions', [ ]), true);
    }



    # Getters / setters

    /**
     * Get refs sorted by the configured order.
     * @deprecated
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
     * @return static
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'        => $this->getName(),
            'displayName' => $this->getDisplayName(),
            'description' => $this->config('description', '')
        ];
    }

    /**
     * getDisplayName method
     * @return string
     */
    public function getDisplayName()
    {
        $displayName = $this->config('display_name', $this->getName());
        return last(explode(' :: ', $displayName));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }



    public function __toString()
    {
        return $this->getName();
    }


}
