<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Menus;


use Codex\Codex;
use Codex\Contracts;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Traits;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory as View;
use Illuminate\Routing\Router;

class Menus extends Extendable implements Contracts\Menus\Menus, Arrayable
{
    use Traits\FilesTrait,
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
     * @param \Codex\Codex        $parent
     * @param \Illuminate\Routing\Router                 $router
     * @param \Illuminate\Contracts\Routing\UrlGenerator $url
     * @param \Illuminate\Contracts\View\View            $view
     */
    public function __construct(Codex $parent, Router $router, Cache $cache, UrlGenerator $url, View $view)
    {
        $this->setCodex($parent);
        $this->setFiles($parent->getFiles());
        $this->cache  = $cache;
        $this->router = $router;
        $this->url    = $url;
        $this->view   = $view;
        $this->items  = new Collection();

        $this->hookPoint('menus:constructed', [ $this ]);
    }


    /**
     * Creates a new menu or returns an existing
     *
     * @param string $id
     *
     * @return \Codex\Menus\Menu
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

        $this->hookPoint('menus:add', [ $id, $menu ]);
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
     * @return \Codex\Menus\Menu
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
        $this->hookPoint('menus:forget', [ $this, $id ]);
        unset($this->items[$id]);
        return $this;
    }

    /**
     * Get cache.
     *
     * @return Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Set cache.
     *
     * @param  \Illuminate\Cache\CacheManager $cache
     *
     * @return Factory
     */
    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    public function toArray()
    {
        return $this->items->toArray();
    }
}
