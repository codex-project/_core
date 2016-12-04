<?php
namespace Codex\Menus;

use Codex\Contracts\Menus\MenuResolver;
use Codex\Contracts\Menus\Menu as MenuContract;
use Codex\Projects\Ref;

class RefsMenuResolver implements MenuResolver
{
    /**
     * handle method
     *
     * @param \Codex\Contracts\Menus\Menu|\Codex\Menus\Menu $menu
     */
    public function handle(MenuContract $menu, Ref $currentRef)
    {
        $refs = $currentRef->getRefs();
        $project = $currentRef->getProject();

        $menu->setAttribute('label', $currentRef->getName());
        $menu->setAttribute('title', 'Version');

        foreach( $refs->all() as $ref){
            $menu
                ->add($ref->getName(), $ref->getName())
                ->setAttribute([
                    'href' => $project->url('index', $ref->getName())
                ]);
        }

    }
}
