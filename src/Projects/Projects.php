<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Projects;

use Codex\Codex;
use Codex\Contracts;
use Codex\Exception\CodexException;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Traits;
use Sebwite\Filesystem\Filesystem;
use Sebwite\Support\Path;
use Sebwite\Support\Str;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Projects
 * @package Codex\Projects
 * @method Project[]|Collection getPhpdocProjects() getPhpdocProjects()
 */
class Projects extends Extendable implements \Codex\Contracts\Projects\Projects
{
    use Traits\FilesTrait;

    /** @var \Codex\Support\Collection */
    protected $items;

    /** @var Project|null */
    protected $activeProject;

    /**
     * Projects constructor.
     *
     * @param \Codex\Codex $parent
     * @param \Sebwite\Support\Filesystem         $files
     */
    public function __construct(Codex $parent, Filesystem $files)
    {
        $this->setCodex($parent);
        $this->setContainer($parent->getContainer());
        $this->setFiles($files);

        $this->items = new Collection;

        $this->hookPoint('projects:construct', [ $this ]);

        $this->findAndRegisterAll();
        $this->resolveProjectsMenu();

        $this->hookPoint('projects:constructed', [ $this ]);
    }

    /**
     * Mark a project as active
     *
     * @param $project
     *
     */
    public function setActive($project)
    {
        if ( ! $project instanceof Project ) {
            $project = $this->get($project);
        }
        $this->activeProject = $project;
        $this->codex->menus->get('projects')->setAttribute('title', $project->getDisplayName());
        $this->hookPoint('projects:active', [ $project ]);
    }

    /**
     * Check if a active project has been set
     * @return bool
     */
    public function hasActive()
    {
        return $this->activeProject !== null;
    }

    /**
     * Gets the active project. Returns null if not set
     * @return \Codex\Projects\Project|null
     */
    public function getActive()
    {
        return $this->activeProject;
    }

    /**
     * Renders the project picker menu
     * @return string
     */
    public function renderMenu()
    {
        return $this->codex->menus->get('projects')->render();
    }

    /**
     * Renders the sidebar menu
     * @return string
     */
    public function renderSidebar()
    {
        return $this->codex->menus->get('sidebar')->render();
    }

    /**
     * Gets a project by name
     *
     * @param string $name The project name
     *
     * @return \Codex\Projects\Project
     * @throws \Codex\Exception\CodexException
     */
    public function get($name)
    {
        if ( ! $this->has($name) ) {
            throw CodexException::projectNotFound((string)$name);
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
        if($name === null){
            return false;
        }
        return $this->items->has($name);
    }

    /**
     * Return all found projects.
     *
     * @return \Codex\Projects\Project[]
     */
    public function all()
    {
        return $this->items->all();
    }

    /**
     * Returns the items (projects) Collection instance to provide advanced sorting and filtering
     *
     * @return \Codex\Support\Collection|\Codex\Projects\Project[]
     */
    public function query()
    {
        return $this->items;
    }

    /**
     * Returns all found projects as array
     * @return array
     */
    public function toArray()
    {
        return $this->items->toArray();
    }

    /**
     * Scans the configured documentation root directory for projects and resolves them and puts them into the projects collection
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function findAndRegisterAll()
    {
        if ( ! $this->items->isEmpty() ) {
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

        foreach ( $projects as $projectDir ) {
            /** @var \SplFileInfo $projectDir */
            $name   = Path::getDirectoryName($projectDir->getPath());
            $config = $this->getContainer()->make('fs')->getRequire($projectDir->getRealPath());
            $config = array_replace_recursive($this->getCodex()->config('default_project_config'), $config);

            /** @var \Codex\Projects\Project $project */
            $project = $this->getContainer()->make('codex.project', [
                'projects' => $this,
                'name'     => $name,
                'config'   => $config,
            ]);


            // This hook allows us to exclude projects from resolving, or do some other stuff
            $hook = $this->hookPoint('projects:resolving', [ $project ]);
            if ( $hook === false ) {
                continue;
            }

            $this->items->put($name, $project);

        }
        $this->hookPoint('projects:resolved', [ $this ]);
    }

    protected function resolveProjectsMenu()
    {
        /** @var \Codex\Menus\Menu $menu */
        $menu = $this->codex->menus->add('projects');
        $menu->setAttribute('title', 'Pick...');
        $menu->setAttribute('subtitle', 'project');

        foreach($this->items->all() as $project){
            /** @var Project $project */

            # Add to menu
            $name  = (string)$project->config('display_name');
            $names = [ ];
            if ( strpos($name, ' :: ') !== false ) {
                $names = explode(' :: ', $name);
                $name  = array_shift($names);
            }

            $href  = $project->url();
            $metas = compact('project');
            $id    = Str::slugify($name, '_');
            if ( ! $menu->has($id) ) {
                $node = $menu->add($id, $name, 'root', count($names) === 0 ? $metas : [ ], count($names) === 0 ? compact('href') : [ ]);
            }

            $parentId = $id;
            while ( count($names) > 0 ) {
                $name = array_shift($names);
                $id .= '::' . $name;
                $id = Str::slugify($id, '_');
                if ( ! $menu->has($id) ) {
                    $node = $menu->add($id, $name, $parentId, $metas, count($names) === 0 ? compact('href') : [ ]);
                }
                $parentId = $id;
            }
            if ( isset($node) ) {
                $this->hookPoint('projects:resolved:node', [ $project, $node ]);
            }
        }
    }

    /**
     * @param \Codex\Projects\Project $project
     * @param null                    $items
     * @param string                  $parentId
     */
    protected function resolveProjectSidebarMenu(Project $project, $items = null, $parentId = 'root')
    {
        if ( $items === null ) {
            $path  = $project->refPath('menu.yml');
            $yaml  = $project->getFiles()->get($path);
            $items = Yaml::parse($yaml)[ 'menu' ];
            $this->codex->menus->forget('sidebar');
        }
        $menu = $this->codex->menus->add('sidebar');

        if(!is_array($items)){
            throw CodexException::invalidMenuConfiguration(": menu.yml in [{$project}]");
        }

        foreach ( $items as $item ) {
            $link = '#';
            if ( array_key_exists('document', $item) ) {
                // remove .md extension if present
                $path = Str::endsWith($item[ 'document' ], '.md', false) ? Str::remove($item[ 'document' ], '.md') : $item[ 'document' ];
                $link = $this->codex->url($project, $project->getRef(), $path);
            } elseif ( array_key_exists('href', $item) ) {
                $link = $item[ 'href' ];
            }

            $id = md5($item[ 'name' ] . $link);

            $node = $menu->add($id, $item[ 'name' ], $parentId);
            $node->setAttribute('href', $link);
            $node->setAttribute('id', $id);

            if ( isset($item[ 'icon' ]) ) {
                $node->setMeta('icon', $item[ 'icon' ]);
            }

            if ( isset($item[ 'children' ]) ) {
                $this->resolveProjectSidebarMenu($project, $item[ 'children' ], $id);
            }
        }
        $this->hookPoint('projects:sidebar:resolve', [ $menu ]);
    }

    /**
     * createGenerator method
     * @return \Codex\Projects\ProjectGenerator
     */
    public function createGenerator()
    {
        return $this->container->make('codex.project.generator');
    }

}
