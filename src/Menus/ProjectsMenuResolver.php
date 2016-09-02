<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Menus;

use Codex\Contracts\Menus\MenuResolver;
use Codex\Projects\Project;
use Laradic\Support\Str;

class ProjectsMenuResolver implements MenuResolver
{
    /**
     * codex method
     *
     * @var \Codex\Codex
     */
    protected $codex;

    /**
     * handle method
     *
     * @param \Codex\Contracts\Menu|\Codex\Menus\Menu $menu
     */
    public function handle(Menu $menu, Project $project = null)
    {
        $menu->setAttribute('title', $project === null ? 'Pick...' : $project->getDisplayName());
        $menu->setAttribute('subtitle', 'project');

        foreach($this->codex->projects->all() as $project){
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

        }

    }
}
