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

use Codex\Codex;
use Codex\Exception\CodexException;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Support\ExtendableCollection;
use Codex\Support\Traits\FilesTrait;
use Laradic\Filesystem\Filesystem;
use Laradic\Support\Path;
use Laradic\Support\Str;
use Symfony\Component\Finder\Finder;

/**
 * Class Projects
 * @package Codex\Entities
 * @method Project[]|Collection getPhpdocProjects() getPhpdocProjects()
 */
class Projects extends ExtendableCollection implements \Codex\Contracts\Projects\Projects
{
    use FilesTrait;

    /** @var Project|null */
    protected $activeProject;

    /**
     * Projects constructor.
     *
     * @param \Codex\Codex $parent
     * @param \Laradic\Support\Filesystem         $files
     */
    public function __construct(Codex $parent, Filesystem $files)
    {
        parent::__construct();
        $this->setCodex($parent);
        $this->setContainer($parent->getContainer());
        $this->setFiles($files);

        $this->hookPoint('projects:construct', [ $this ]);

        $this->findAndRegisterAll();
        $this->getCodex()->dev->stopMeasure('Projects::findAndRegisterAll');

        $this->hookPoint('projects:constructed', [ $this ]);
    }

    /**
     * Scans the configured documentation root directory for projects and resolves them and puts them into the projects collection
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function findAndRegisterAll()
    {
        if (! $this->items->isEmpty()) {
            return;
        }
        $this->hookPoint('projects:resolve', [ $this ]);

        $finder   = new Finder();
        $projects = $finder
            ->in($this->getCodex()->getDocsPath())
            ->files()
            ->name('config.php')
            ->depth('<= 1')
            ->followLinks();

        $fs = $this->getContainer()->make('fs');
        foreach ($projects as $projectDir) {
            /** @var \SplFileInfo $projectDir */
            $name   = Path::getDirectoryName($projectDir->getPath());

            $config = $fs->getRequire($projectDir->getRealPath());
            $config = array_replace_recursive(config('codex.projects.default_config'), $config);

//            /** @var \Codex\Entities\Project $project */
//            $project = $this->getContainer()->makeWith('codex.project', [
//                'projects' => $this,
//                'name'     => $name,
//                'config'   => $config,
//            ]);


            // This hook allows us to exclude projects from resolving, or do some other stuff
            $hook = $this->hookPoint('projects:resolving', [ $name, $config ]);
            if ($hook === false) {
                continue;
            }

            $this->items->put($name, $config);
        }
        $this->hookPoint('projects:resolved', [ $this ]);
    }


    /**
     * Gets a project by name
     *
     * @param string $name The project name
     *
     * @return \Codex\Entities\Project
     * @throws \Codex\Exception\CodexException
     */
    public function get($name)
    {
        if (! $this->has($name)) {
            throw CodexException::projectNotFound($name);
        }

        $project = parent::get($name);
        if(!$project instanceof Project){
            $project = $this->build('codex.project', [
                'projects' => $this,
                'name'     => $name,
                'config'   => $project,
            ]);
        }
        return $project;
    }

    /**
     * Check if the given project exists.
     *
     * @param  string $name
     *
     * @return bool
     */
    public function has($name)
    {
        if ($name === null) {
            return false;
        }
        return $this->items->has($name);
    }

    /**
     * Return all found projects.
     *
     * @return \Codex\Entities\Project[]
     */
    public function all()
    {
        return $this->items->all();
    }

    /**
     * Returns the items (projects) Collection instance to provide advanced sorting and filtering
     *
     * @return \Codex\Support\Collection|\Codex\Entities\Project[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * isEmpty method
     * @return bool
     */
    public function isEmpty()
    {
        return $this->items->isEmpty();
    }

    /**
     * Returns all found projects as array
     * @return array
     */
    public function toArray()
    {
        return $this->getItems()->map(function (\Codex\Entities\Project $project) {
            return [ 'name' => $project->getName(), 'displayName' => $project->getDisplayName() ];
        })->toArray();
    }


    /**
     * createGenerator method
     *
*@return \Codex\Entities\ProjectGenerator
     */
    public function createGenerator()
    {
        return $this->container->make('codex.project.generator');
    }
}
