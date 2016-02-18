<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Menus;


class Menus
{

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
     * @param \Illuminate\Contracts\Container\Container   $container
     * @param \Illuminate\Contracts\Filesystem\Filesystem $files
     * @param \Illuminate\Contracts\Cache\Repository      $cache
     * @param \Illuminate\Routing\Router                  $router
     * @param \Illuminate\Contracts\Routing\UrlGenerator  $url
     * @param \Illuminate\Contracts\View\Factory          $view
     */
    public function __construct(Codex $parent, Filesystem $files, Cache $cache, Router $router, UrlGenerator $url, View $view)
    {
        $this->setFiles($files);
        $this->cache  = $cache;
        $this->router = $router;
        $this->url    = $url;
        $this->view   = $view;
        $this->items  = new Collection();

        $this->runHook('menus:ready', [ $this ]);
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
        if ($this->has($id)) {
            return $this->get($id);
        }

        $menu = $this->getContainer()->make('codex.menu', [
            'menus' => $this,
            'id'          => $id
        ]);
        $this->runHook('menus:add', [ $this, $menu ]);
        $this->items->put($id, $menu);

        return $menu;
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
     * Removes a menu
     *
     * @param $id
     *
     * @return MenuFactory
     */
    public function forget($id)
    {
        $this->runHook('menu-factory:forget', [ $this, $id ]);
        $this->items->forget($id);

        return $this;
    }
}
