<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Components\Factory;

use Codex\Core\Contracts\Codex;
use Codex\Core\Traits\Hookable;
use Sebwite\Support\Filesystem;
use Sebwite\Support\Path;
use Sebwite\Support\Str;
use Symfony\Component\Finder\Finder;

/**
 * This is the class Projects.
 *
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class Projects extends FactoryComponent
{
    use Hookable;

    protected $items;

    protected $fs;

    public function __construct(Codex $parent, Filesystem $fs)
    {
        parent::__construct($parent);
        $this->fs    = $fs;
        $this->items = collect();

        $this->runHook('projects:ready', [$this]);

        $this->resolve();

        $this->runHook('projects:done', [$this]);
    }

    public function create()
    {
    }

    /**
     * Scans the configured documentation root directory for projects and resolves them and puts them into the projects collection
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function resolve()
    {
        if (!$this->items->isEmpty()) {
            return;
        }
        $this->runHook('projects:resolve', [$this]);
        /** @var \Codex\Core\Menu $menu */
        $menu     = $this->codex->menus->add('projects');
        $finder   = new Finder();
        $projects = $finder->in($this->getCodex()->getRootDir())->files()->name('config.php')->depth('<= 1')->followLinks();

        foreach ($projects as $projectDir) {
        # Make project

            /** @var \SplFileInfo $projectDir */
            $name   = Path::getDirectoryName($projectDir->getPath());
            $config = $this->getContainer()->make('fs')->getRequire($projectDir->getRealPath());
            $config = array_replace_recursive($this->getCodex()->config('default_project_config'), $config);

            /** @var \Codex\Core\Project $project */
            $project = $this->getContainer()->make('codex.project', [
                'codex'  => $this,
                'name'   => $name,
                'config' => $config
            ]);

            $this->runHook('project:make', [ $this, $project ]);
            $this->items->put($name, $project);

            # Add to menu
            $name  = (string)$project->config('display_name');
            $names = [ ];
            if (strpos($name, ' :: ') !== false) {
                $names = explode(' :: ', $name);
                $name  = array_shift($names);
            }

            $href  = $project->url();
            $metas = compact('project');
            $id    = Str::slugify($name, '_');
            if (!$menu->has($id)) {
                $menu->add($id, $name, 'root', count($names) === 0 ? $metas : [], count($names) === 0 ? compact('href') : [ ]);
            }

            $parentId = $id;
            while (count($names) > 0) {
                $name = array_shift($names);
                $id .= '::' . $name;
                $id = Str::slugify($id, '_');
                if (!$menu->has($id)) {
                    $menu->add($id, $name, $parentId, $metas, count($names) === 0 ? compact('href') : [ ]);
                }
                $parentId = $id;
            }
        }
        $this->runHook('projects:resolved', [$this]);
    }

    public function menu()
    {
        return $this->codex->menus->get('projects');
    }

    /**
     * Returns a project instance for the given name
     *
     * @param $name
     *
     * @return \Codex\Core\Project
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new \InvalidArgumentException("Project [$name] could not be found in [{$this->rootDir}]");
        }

        return $this->items->get($name);
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
        return $this->items->has($name);
    }

    /**
     * Return all found projects.
     *
     * @return \Codex\Core\Project[]
     */
    public function all()
    {
        return $this->items->all();
    }

    public function toArray()
    {
        return $this->items->all();
    }
}
