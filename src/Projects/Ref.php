<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Projects;

use Codex\Codex;
use Codex\Exception\CodexException;
use Codex\Support\Extendable;
use Codex\Support\Traits\ConfigTrait;
use Codex\Support\Traits\FilesTrait;
use Codex\Support\Version;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class Ref.
 *
 * @property \Codex\Documents\Documents    $documents
 * @property \Codex\Addon\Phpdoc\PhpdocRef $phpdoc
 *
 * @package        Codex\Projects
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 *
 */
class Ref extends Extendable implements Arrayable
{
    use FilesTrait,
        ConfigTrait;

    /** @var string */
    protected $name;

    /** @var Project */
    protected $project;

    /** @var Refs */
    protected $refs;

    protected $version;

    protected $path;

    /**
     * Ref constructor.
     *
     * @param \Codex\Codex            $codex
     * @param \Codex\Projects\Project $project
     * @param \Codex\Projects\Refs    $refs
     * @param           string        $name
     */
    public function __construct(Codex $codex, Project $project, Refs $refs, $name)
    {
        $this->setCodex($codex);
        $this->setFiles($project->getFiles());

        $this->name    = $name;
        $this->project = $project;
        $this->refs    = $refs;
        $this->path    = $project->path($name);

        $this->hookPoint('ref:construct', [ $this ]);

        // set config
        $this->setConfig(config('codex.refs.default_config', []));
        $inheritConfig = $this->getProject()->config()->only(config('codex.refs.inherit_config', []))->toArray();
        $this->mergeConfig($inheritConfig);

        $fs = $this->getFiles();
        if ($fs->exists($this->path('codex.yml'))) {
            $yaml = $fs->get($this->path('codex.yml'));
            $this->mergeConfig(Yaml::parse($yaml));
        }

        $this->hookPoint('ref:constructed', [ $this ]);
    }

    /**
     * Checks if this ref is a version. Versions are refs that are named using semver specification (as in 1.0.0, 2.3.4-beta)
     *
     * @return bool
     */
    public function isVersion()
    {
        if ($this->version === null) {
            $this->version = Version::create($this->name);
        }
        return $this->version !== false;
    }

    public function getVersion()
    {
        if ($this->isVersion() === false) {
            throw CodexException::create("Can not getVersion for Ref {$this->project}/{$this}. The Ref is not a semver. Check by using isVersion() first.");
        }
        return $this->version;
    }


    /**
     * Checks if this ref is a branch. Branches are refs that are not named using semver specification. (as in master, develop, hi-this-is-version-1-lol)
     *
     * @return bool
     */
    public function isBranch()
    {
        return $this->isVersion() === false;
    }


    public function __toString()
    {
        return $this->name;
    }

    public function path($path = null)
    {
        return $path === null ? $this->name : path_join($this->name, $path);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return \Codex\Projects\Refs
     */
    public function getRefs()
    {
        return $this->refs;
    }

    public function hasSidebarMenu()
    {
        return $this->config('menu', false) !== false;
    }

    /**
     * getSidebarMenu method
     * @return \Codex\Menus\Menu
     */
    public function getSidebarMenu()
    {
        $menu = $this->getCodex()->menus->get('sidebar');
        $menu->resolve([ $this->project, $this ]);
        return $menu;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'      => $this->getName(),
            'config'    => $this->getConfig(),
            'isBranch'  => $this->isBranch(),
            'isVersion' => $this->isVersion(),
            'menu'      => $this->getSidebarMenu()->toArray(),
//            'renderedMenu' => $menu->render($this->project, $this)
        ];
    }
}
