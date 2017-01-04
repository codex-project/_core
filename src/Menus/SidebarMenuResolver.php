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
namespace Codex\Menus;

use Codex\Codex;
use Codex\Contracts\Menus\MenuResolver;
use Codex\Exception\CodexException;
use Codex\Projects\Project;
use Codex\Projects\Ref;
use Laradic\Support\Str;

class SidebarMenuResolver implements MenuResolver
{
    /** @var Menu */
    protected $menu;

    protected $project;

    /** @var Ref */
    protected $ref;

    /** @var Codex */
    protected $codex;

    /**
     * SidebarMenuResolver constructor.
     *
     * @param \Codex\Codex $codex
     */
    public function __construct(Codex $codex)
    {
        $this->codex = $codex;
    }


    public function handle(Menu $menu, $project, $ref)
    {
        $project = $project instanceof Project ? $project : $this->codex->projects->get($project);
        $ref     = $ref instanceof Ref ? $ref : $project->refs->get($ref);

        $this->menu    = $menu;
        $this->project = $project;
        $this->ref     = $ref;

        $menu->setView($this->codex->view('menus.sidebar'));
        $this->menu->clear();
        $items = $ref->config('menu', []);

        if (!is_array($items)) {
            throw CodexException::invalidMenuConfiguration(": menu.yml in [{$this}]");
        }

        $this->recurse($items);
    }

    /**
     * recurse method
     *
     * @param array  $items
     * @param string $parentId
     */
    protected function recurse($items = [], $parentId = 'root')
    {

        foreach ($items as $item) {
            $link = 'javascript:;';
            $type = null;
            if (array_key_exists('document', $item)) {
                $type = 'document';
                // remove .md extension if present
                $path = ends_with($item[ 'document' ], [ '.md' ]) ? Str::remove($item[ 'document' ], '.md') : $item[ 'document' ];
                $link = $this->codex->url($this->ref->getProject(), $this->ref->getName(), $path);
            } elseif (array_key_exists('href', $item)) {
                $type = 'href';
                $link = $item[ 'href' ];
            }

            $id = md5($item[ 'name' ] . $link);

            $node = $this->menu->add($id, $item[ 'name' ], $parentId);
            $node->setAttribute('href', $link);
            $node->setAttribute('id', $id);


            if (isset($path)) {
                $node->setMeta('path', $path);
            }
            if (isset($item[ 'icon' ])) {
                $node->setMeta('icon', $item[ 'icon' ]);
            }

            if (isset($item[ 'children' ])) {
                $type = 'parent';
            }

            $node->setMeta('type', $type);

            if (isset($item[ 'children' ])) {
                $this->recurse($item[ 'children' ], $id);
            }
        }
    }
}
