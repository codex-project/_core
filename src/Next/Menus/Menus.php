<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Menus;


use Codex\Core\Next\Contracts;
use Codex\Core\Next\Contracts\Codex;
use Codex\Core\Next\Support\Collection;
use Codex\Core\Next\Traits;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory as View;
use Illuminate\Routing\Router;

class Menus implements
    Contracts\Menus,
    Contracts\Hookable
{
    use
        Traits\HookableTrait,

        Traits\CodexTrait,
        Traits\FilesTrait,
        Traits\ConfigTrait;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * Menus constructor.
     *
     * @param \Codex\Core\Next\Contracts\Codex|\Codex\Core\Next\Codex $parent
     * @param \Illuminate\Routing\Router                              $router
     * @param \Illuminate\Contracts\Routing\UrlGenerator              $url
     * @param \Illuminate\Contracts\View\View                         $view
     */
    public function __construct(Codex $parent, Router $router, UrlGenerator $url, View $view)
    {
        $this->setCodex($parent);
        $this->setFiles($parent->getFiles());
        $this->cache  = $parent->getCache();
        $this->router = $router;
        $this->url    = $url;
        $this->view   = $view;
        $this->items  = new Collection();

        $this->hookPoint('menus:ready', [ $this ]);
    }


    /**
     * Creates a new menu or returns an existing
     *
     * @param string $id
     *
     * @return \Codex\Core\Menu
     */
    public function add($id)
    {
        if ( $this->has($id) ) {
            return $this->get($id);
        }

        $menu = $this->getCodex()->getContainer()->make('codex.menu', [
            'menus' => $this,
            'id'    => $id,
        ]);

        $this->hookPoint('menus:add', [ $this, $menu ]);
        $this->items->put($id, $menu);

        return $menu;
    }

    /**
     * has
     *
     * @param $id
     *
     * @return bool
     */
    public function has($id)
    {
        return $this->items->has($id);
    }

    /**
     * Returns a menu
     *
     * @param string $id
     * @param null   $default
     *
     * @return \Codex\Core\Menu
     */
    public function get($id, $default = null)
    {
        return $this->items->get($id, $default);
    }

    /**
     * Removes a menu
     *
     * @param $id
     *
     * @return MenuFactory
     */
    public function forget($id)
    {
        $this->hookPoint('menu-factory:forget', [ $this, $id ]);
        $this->items->forget($id);

        return $this;
    }
}
