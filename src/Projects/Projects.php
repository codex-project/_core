<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Projects;

use Codex\Core\Contracts;
use Codex\Core\Exception\ProjectNotFoundException;
use Codex\Core\Traits;
use Laradic\Support\Filesystem;
use Laradic\Support\Path;
use Laradic\Support\Str;
use Symfony\Component\Finder\Finder;

class Projects implements
    Contracts\Projects,
    Contracts\Hookable
{
    use Traits\HookableTrait,

        Traits\FilesTrait,
        Traits\CodexTrait,
        Traits\ContainerTrait;

    protected $items;

    /**
     * Projects constructor.
     *
     * @param \Codex\Core\Contracts\Codex|\Codex\Core\Codex $parent
     * @param \Laradic\Support\Filesystem                   $files
     */
    public function __construct(Contracts\Codex $parent, Filesystem $files)
    {
        $this->setCodex($parent);
        $this->setContainer($parent->getContainer());
        $this->setFiles($files);

        $this->items = collect();

        $this->hookPoint('projects:ready', [$this]);

        $this->resolve();

        $this->hookPoint('projects:done', [$this]);
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
        $this->hookPoint('projects:resolve', [$this]);
        /** @var \Codex\Core\Menus\Menu $menu */
        $menu     = $this->codex->menus->add('projects');
        $finder   = new Finder();
        $projects = $finder
            ->in($this->getCodex()->getRootDir())
            ->files()
            ->name('config.php')
            ->depth('<= 1')
            ->followLinks();

        foreach ($projects as $projectDir) {
            # Make project

            /** @var \SplFileInfo $projectDir */
            $name   = Path::getDirectoryName($projectDir->getPath());
            $config = $this->getContainer()->make('fs')->getRequire($projectDir->getRealPath());
            $config = array_replace_recursive($this->getCodex()->config('default_project_config'), $config);

            /** @var \Codex\Core\Projects\Project $project */
            $project = $this->getContainer()->make('codex.project', [
                'projects' => $this,
                'name'   => $name,
                'config' => $config
            ]);

            $this->hookPoint('project:make', [ $this, $project ]);
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
        $this->hookPoint('projects:resolved', [$this]);
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
     * @return \Codex\Core\Projects\Project
     * @throws \Codex\Core\Exception\ProjectNotFoundException
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw ProjectNotFoundException::in($this)->project($name);
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
