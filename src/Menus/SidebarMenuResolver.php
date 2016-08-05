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
use Codex\Projects\Ref;
use Sebwite\Support\Str;

class SidebarMenuResolver implements MenuResolver
{
    /** @var Menu */
    protected $menu;

    /** @var Ref */
    protected $ref;

    /** @var Codex */
    protected $codex;

    public function handle(Menu $menu, Ref $ref, Codex $codex)
    {
        $this->ref   = $ref;
        $this->codex = $codex;

        $codex->menus->has('sidebar') && $codex->menus->forget('sidebar');
        $this->menu = $codex->menus->add('sidebar');
        $this->menu->setView($codex->view('menus.sidebar'));
        $items = $ref->config('menu', [ ]);

        if ( ! is_array($items) ) {
            throw CodexException::invalidMenuConfiguration(": menu.yml in [{$this}]");
        }
    }

    /**
     * recurse method
     *
     * @param array  $items
     * @param string $parentId
     */
    protected function recurse($items = [], $parentId = 'root')
    {

        foreach ( $items as $item ) {
            $link = '#';
            if ( array_key_exists('document', $item) ) {
                // remove .md extension if present
                $path = ends_with($item[ 'document' ], [ '.md' ]) ? Str::remove($item[ 'document' ], '.md') : $item[ 'document' ];
                $link = $this->codex->url($this->ref->getProject(), $this->ref->getName(), $path);
            } elseif ( array_key_exists('href', $item) ) {
                $link = $item[ 'href' ];
            }

            $id = md5($item[ 'name' ] . $link);

            $node = $this->menu->add($id, $item[ 'name' ], $parentId);
            $node->setAttribute('href', $link);
            $node->setAttribute('id', $id);

            if ( isset($item[ 'icon' ]) ) {
                $node->setMeta('icon', $item[ 'icon' ]);
            }

            if ( isset($item[ 'children' ]) ) {
                $this->recurse($item[ 'children' ], $id);
            }
        }
    }
}
