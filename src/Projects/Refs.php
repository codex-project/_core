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

use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Support\ExtendableCollection;
use Codex\Support\Traits\FilesTrait;
use Illuminate\Contracts\Support\Arrayable;
use vierbergenlars\SemVer\version;

/**
 * This is the class Refs.
 *
 * @package        Codex\Projects
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method Ref get($name)
 */
class Refs extends ExtendableCollection implements Arrayable
{
    use FilesTrait;

    /** Automaticly picks a ref based on priority. LAST_VERSION (otherwise)> MASTER (otherwise)> FIRST_DIRECTORY  */
    const DEFAULT_AUTO = 'auto';
    const DEFAULT_MASTER = 'master';
    const DEFAULT_LAST_VERSION = 'last';
    const DEFAULT_FIRST_DIRECTORY = 'first';
    const DEFAULT_CUSTOM = 'custom';

    /** @var \Codex\Support\Collection|Ref[] */
    protected $items;

    /** @var Project|null */
    protected $project;

    /**
     * Versions are refs that are named using semver specification (as in 1.0.0, 2.3.4-beta)
     * @var array
     */
    protected $versions = [];

    /**
     * Branches are refs that are not named using semver specification. (as in master, develop, hi-this-is-version-1-lol)
     * @var array
     */
    protected $branches = [];

    /**
     * The default ref name
     * @var string
     */
    protected $default;

    /**
     * Projects constructor.
     *
     * @param \Codex\Codex                $parent
     * @param \Laradic\Support\Filesystem $files
     */
    public function __construct(Project $parent)
    {
        parent::__construct();
        $this->setCodex($parent->getCodex());
        $this->setContainer($parent->getContainer());
        $this->setFiles($parent->getFiles());

        $this->project = $parent;

        $this->hookPoint('refs:construct', [ $this ]);
        $this->resolveRefs();
        $this->hookPoint('refs:constructed', [ $this ]);
    }

    protected function resolveRefs()
    {
        // Scan refs (directories) and instaniate / add em to the collection
        $directories = $this->getFiles()->directories();
        foreach ($directories as $directory) {
            /** @var Ref $ref */
            $ref = $this->app->make('codex.ref', [
                'name'    => $directory,
                'project' => $this->project,
                'refs'    => $this,
            ]);

            $this->items->put($directory, $ref);

            // if the ref is a (semver) version, we add it to versions, so we can easily reference it laster (sort etc)
            if ($ref->isVersion()) {
                $this->versions[] = $ref;
            } elseif ($ref->isBranch()) {
                $this->branches[] = $ref;
            }
        }


        // Resolve default ref
        $defaultRef = $this->items->first()->getName(); // DEFAULT_FIRST_DIRECTORY
        switch ($this->project->config('default')) {
            case static::DEFAULT_AUTO:
                break;

            case static::DEFAULT_MASTER:
                $defaultRef = 'master';
                break;
            case static::DEFAULT_LAST_VERSION:
                $defaultRef = collect($this->versions)->sort(function (Ref $one, Ref $two) {
                    return version::gt($one->getVersion(), $two->getVersion()) ? -1 : 1;
                })->first()->getName();
                break;
            case static::DEFAULT_FIRST_DIRECTORY:
                $defaultRef = $this->items->first()->getName();
                break;
            case static::DEFAULT_CUSTOM:
                $defaultRef = $this->project->config('custom');
                break;
        }

        $this->default = (string)$defaultRef;
    }

    /**
     * Get default ref.
     *
     * @return Ref
     */
    public function getDefault()
    {
        return $this->items->get($this->default);
    }

    public function getDefaultName()
    {
        return $this->default;
    }


    # Getters / setters

    /**
     * getBranches method
     * @return Ref[]
     */
    public function getBranches()
    {
        return $this->branches;
    }

    /**
     * Get versions.
     *
     * @deprecated
     * @return Ref[]
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * hasVersions method
     * @return bool
     */
    public function hasVersions()
    {
        return count($this->versions) > 0;
    }

    /**
     * getLastVersion method
     * @return Ref
     */
    public function getLastVersion()
    {
        return head($this->getSortedVersions());
    }

    /**
     * getSortedVersions method
     * @return Ref[]
     */
    public function getSortedVersions()
    {
        return collect($this->versions)->sort(function (version $v1, version $v2) {
            return version::gt($v1, $v2) ? -1 : 1;
        })->toArray();
    }

    /**
     * getSortedBranches method
     * @return Ref[]
     */
    public function getSortedBranches()
    {
        $branches = $this->branches;
        usort($branches, function ($a, $b) {
            return strcmp((string)$a, (string)$b);
        });
        return $branches;
    }

    /**
     * getSorted method
     * @return Ref[]
     */
    public function getSorted()
    {
        return array_merge($this->getSortedBranches(), $this->getSortedVersions());
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {

        return [
            'default' => $this->getDefaultName(),
            'items'   => $this->getItems()->map(function (\Codex\Projects\Ref $ref) {
                return $ref->getName();
            })->values()->toArray(),
        ];
    }
}
