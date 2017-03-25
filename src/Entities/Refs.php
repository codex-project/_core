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
namespace Codex\Entities;

use Codex\Exception\CodexException;
use Codex\Support\ExtendableCollection;
use Codex\Support\Traits\FilesTrait;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\Yaml\Yaml;
use Codex\Support\Version;

/**
 * This is the class Refs.
 *
 * @package        Codex\Entities
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 *
 * @method \Codex\Entities\Ref[] all()
 */
class Refs extends ExtendableCollection implements Arrayable
{
    use FilesTrait;

    /** Automaticly picks a ref based on priority. LAST_VERSION otherwise MASTER otherwise FIRST_DIRECTORY  */
    const DEFAULT_AUTO = 1;

    /** MASTER otherwise FIRST_DIRECTORY   */
    const DEFAULT_MASTER = 2;

    /** LAST_VERSION otherwise FIRST_DIRECTORY   */
    const DEFAULT_LAST_VERSION = 3;

    /**  */
    const DEFAULT_FIRST_DIRECTORY = 4;

    /** @var \Illuminate\Support\Collection|array[]|\Codex\Support\Collection|Ref[] */
    protected $items;

    /** @var Project|null */
    protected $project;

    /**
     * Versions are refs that are named using semver specification (as in 1.0.0, 2.3.4-beta)
     *
     * @var string[]
     */
    protected $versions = [];

    /**
     * Branches are refs that are not named using semver specification. (as in master, develop, hi-this-is-version-1-lol)
     *
     * @var string[]
     */
    protected $branches = [];

    /**
     * The default ref name
     *
     * @var string
     */
    protected $default;

    /**
     * Projects constructor.
     *
     * @param \Codex\Entities\Project     $parent
     * @param \Laradic\Support\Filesystem $files
     */
    public function __construct($parent)
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

        $inheritKeys     = config('codex.refs.inherits_config', []);
        $inheritedConfig = $this->getProject()->config()->only($inheritKeys)->toArray();
        $defaultConfig   = config('codex.refs.default_config', []);
        $defaultConfig   = array_replace_recursive($defaultConfig, $inheritedConfig);

        foreach ($directories as $name) {
            $configPath = path_join($name, 'codex.yml');
            if (!$this->getFiles()->exists($configPath)) {
                continue;
            }
            $yaml   = $this->getFiles()->get($configPath);
            $config = array_replace_recursive($defaultConfig, Yaml::parse($yaml));

            $this->items->put($name, $config);

            if (Version::create($name) === false) {
                $this->branches[] = $name;
            } else {
                $this->versions[] = $name;
            }

//            // if the ref is a (semver) version, we add it to versions, so we can easily reference it laster (sort etc)
//            if ($ref->isVersion()) {
//                $this->versions[] = $ref;
//            } elseif ($ref->isBranch()) {
//                $this->branches[] = $ref;
//            }
        }
    }

    /**
     * Get default ref.
     *
     * @return Ref
     */
    public function getDefault()
    {
        return $this->get($this->getDefaultName());
    }

    public function getDefaultName()
    {
        if (null === $this->default) {
            // Resolve default ref
            $defaultRef = head($this->keys());
            switch ($this->project->config('default')) {
                case static::DEFAULT_AUTO:
                    if ($this->hasVersions()) {
                        $defaultRef = $this->getLastVersion();
                        break;
                    }
                    $defaultRef = $this->has('master') ? 'master' : head($this->keys());
                    break;

                case static::DEFAULT_MASTER:
                    $defaultRef = $this->has('master') ? 'master' : head($this->keys());
                    break;
                case static::DEFAULT_LAST_VERSION:
                    $defaultRef = $this->hasVersions() ? $this->getLastVersion() : head($this->getSortedBranches());
                    break;
                case static::DEFAULT_FIRST_DIRECTORY:
                    $defaultRef = head($this->keys());
                    break;
                default:
                    $defaultRef = $this->project->config('default');
                    break;
            }
            $this->default = (string)$defaultRef;
        }
        return $this->default;
    }

    public function get($name)
    {
        if (!$this->has($name)) {
            throw CodexException::refNotFound($name, $this);
        }
        $ref = parent::get($name);
        if (!$ref instanceof Ref) {
            $this->items->put($name, $ref = $this->build('codex.ref', [
                'name'   => $name,
                'refs'   => $this,
                'config' => $ref,
            ]));
        }
        return $ref;
    }

    # Getters / setters

    /**
     * getBranches method
     *
     * @return string[]
     */
    public function getBranches()
    {
        return $this->branches;
    }

    /**
     * Get versions.
     *
     * @deprecated
     * @return string[]
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * hasVersions method
     *
     * @return bool
     */
    public function hasVersions()
    {
        return count($this->versions) > 0;
    }

    /**
     * getLastVersion method
     *
     * @return Ref
     */
    public function getLastVersion()
    {
        return head($this->getSortedVersions());
    }

    /**
     * getSortedVersions method
     *
     * @return Ref[]
     */
    public function getSortedVersions()
    {
        return collect($this->versions)->sort(function ($one, $two) {
            return version::gt((string)$one, (string)$two) ? -1 : 1;
        })->toArray();
    }

    /**
     * getSortedBranches method
     *
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
     * getProject method
     *
     * @return \Codex\Entities\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * getSorted method
     *
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
            'items'   => $this->keys(),
        ];
    }
}
