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
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Traits;
use vierbergenlars\SemVer\version;


class Refs extends Extendable
{
    use Traits\FilesTrait;

    /** Automaticly picks a ref based on priority. LAST_VERSION (otherwise)> MASTER (otherwise)> FIRST_DIRECTORY  */
    const DEFAULT_AUTO = 'auto';
    const DEFAULT_MASTER = 'master';
    const DEFAULT_LAST_VERSION = 'last';
    const DEFAULT_FIRST_DIRECTORY = 'first';
    const DEFAULT_CUSTOM = 'custom';

    /** @var \Codex\Support\Collection */
    protected $items;

    /** @var Project|null */
    protected $project;

    /**
     * Versions are refs that are named using semver specification (as in 1.0.0, 2.3.4-beta)
     * @var array
     */
    protected $versions = [ ];

    /**
     * Branches are refs that are not named using semver specification. (as in master, develop, hi-this-is-version-1-lol)
     * @var array
     */
    protected $branches = [ ];

    /**
     * The default ref name
     * @var string
     */
    protected $default;

    /**
     * Projects constructor.
     *
     * @param \Codex\Codex                $parent
     * @param \Sebwite\Support\Filesystem $files
     */
    public function __construct(Project $parent)
    {
        $this->setCodex($parent->getCodex());
        $this->setContainer($parent->getContainer());
        $this->setFiles($parent->getFiles());

        $this->project = $parent;
        $this->items   = new Collection;

        $this->hookPoint('refs:construct', [ $this ]);

        $this->resolveRefs();

        $this->hookPoint('refs:constructed', [ $this ]);
    }

    /**
     * get method
     *
     * @param $ref
     *
     * @return Ref
     */
    public function get($ref)
    {
        return $this->items->get($ref);
    }

    /**
     * has method
     *
     * @param $ref
     *
     * @return boolean
     */
    public function has($ref)
    {
        return $this->items->get($ref);
    }


    protected function resolveRefs()
    {
        // Scan refs (directories) and instaniate / add em to the collection
        $directories = $this->getFiles()->directories();
        foreach ( $directories as $directory ) {
            /** @var Ref $ref */
            $ref = $this->app->make('codex.project.ref', [
                'name'    => $directory,
                'project' => $this->project,
                'refs'    => $this,
            ]);

            $this->items->put($directory, $ref);

            // if the ref is a (semver) version, we add it to versions, so we can easily reference it laster (sort etc)
            if ( $ref->isVersion() ) {
                $this->versions[] = $ref->getVersion();
            }
        }


        // Resolve default ref
        $defaultRef = $this->items->first()->getName(); // DEFAULT_FIRST_DIRECTORY
        switch ( $this->project->config('default') ) {
            case static::DEFAULT_AUTO:
                break;

            case static::DEFAULT_MASTER:
                $defaultRef = 'master';
                break;
            case static::DEFAULT_LAST_VERSION:
                $defaultRef = collect($this->versions)->sort(function (version $v1, version $v2) {
                    return version::gt($v1, $v2) ? -1 : 1;
                })->first();
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
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
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
     * Get versions.
     *
     * @deprecated
     * @return array
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
     * @return version
     */
    public function getLastVersion()
    {
        return collect($this->versions)->sort(function (version $v1, version $v2) {
            return version::gt($v1, $v2) ? -1 : 1;
        })->first();
    }

}
