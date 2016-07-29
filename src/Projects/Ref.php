<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Projects;


use Codex\Codex;
use Codex\Contracts;
use Codex\Exception\CodexException;
use Codex\Support\Extendable;
use Codex\Traits;
use vierbergenlars\SemVer\SemVerException;
use vierbergenlars\SemVer\version;

/**
 * This is the class Ref.
 *
 * @package        Codex\Projects
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @property \Codex\Documents\Documents $documents
 *
 */
class Ref extends Extendable
{
    use Traits\FilesTrait,
        Traits\ConfigTrait;

    /** @var string */
    protected $name;

    /** @var Project */
    protected $project;

    /** @var Refs */
    protected $refs;

    protected $version;

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
    }

    /**
     * Checks if this ref is a version. Versions are refs that are named using semver specification (as in 1.0.0, 2.3.4-beta)
     * @return bool
     */
    public function isVersion()
    {
        if ( $this->version === null ) {
            try {
                $this->version = new version($this->name);
            }
            catch (SemVerException $e) {
                $this->version = false;
            }
        }
        return $this->version instanceof version;
    }

    public function getVersion()
    {
        if ( $this->isVersion() === false ) {
            throw CodexException::because("Can not getVersion for Ref {$this->project}/{$this}. The Ref is not a semver. Check by using isVersion() first.");
        }
        return $this->version;
    }


    /**
     * Checks if this ref is a branch. Branches are refs that are not named using semver specification. (as in master, develop, hi-this-is-version-1-lol)
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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}
