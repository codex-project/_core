<?php
namespace Codex\Core\Menus;

use Codex\Core\Contracts\Menus\MenuFactory as MenuFactoryContract;
use Codex\Core\Traits\Hookable;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;

/**
 * Menu class.
 *
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class Menu
{
    use Hookable;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * @var \Codex\Core\Factory
     */
    protected $factory;

    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    /**
     * @var string
     */
    protected $view;

    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $viewFactory;

    /**
     * @var \Codex\Core\Contracts\Menus\MenuFactory
     */
    protected $menus;

    /**
     * @param \Codex\Core\Contracts\Menus\MenuFactory     $menus
     * @param \Illuminate\Contracts\Filesystem\Filesystem $files
     * @param \Illuminate\Contracts\Cache\Repository      $cache
     * @param \Illuminate\Routing\Router                  $router
     * @param \Illuminate\Contracts\Routing\UrlGenerator  $url
     * @param \Illuminate\Contracts\View\Factory          $viewFactory
     */
    public function __construct(MenuFactoryContract $menus, Filesystem $files, Cache $cache, Router $router, UrlGenerator $url, ViewFactory $viewFactory, $id = '')
    {
        $this->menus       = $menus;
        $this->cache       = $cache;
        $this->router      = $router;
        $this->url         = $url;
        $this->files       = $files;
        $this->viewFactory = $viewFactory;
        $this->view        = 'codex::menus.' . $id;
        $this->items       = new Collection();

        $this->runHook('menu:ready', [ $this ]);

        $this->items->put('root', new Node('root', $this, 'root'));

        $this->runHook('menu:done', [ $this ]);
    }

    /**
     * Renders the menu using the defined view
     *
     * @return string
     */
    public function render()
    {
        $vars = [
            'menu'  => $this,
            'items' => $this->get('root')->getChildren()
        ];

        $rendered = $this->viewFactory->make($this->view)->with($vars)->render();

        return $rendered;
    }

    /**
     * Add a menu item
     *
     * @param        $id
     * @param        $value
     * @param string $parent
     * @param array  $meta
     * @param array  $attributes
     *
*@return \Codex\Core\Menus\Node
     */
    public function add($id, $value, $parent = 'root', array $meta = [ ], array $attributes = [ ])
    {
        $node = new Node($id, $this, $value);
        $node->setMeta($meta);
        $node->setAttribute($attributes);

        if (! is_null($parent) and $this->items->has($parent)) {
            $parentNode = $this->items->get($parent);
            $parentNode->addChild($node);
            $node->setParent($parentNode);
            $node->setMeta('data-parent', $parent);
        }

        $this->items->put($id, $node);

        return $node;
    }

    /**
     * Checks if a menu item exists
     *
     * @param $id
     * @return bool
     */
    public function has($id)
    {
        return $this->items->has($id);
    }

    /**
     * Get a menu item
     *
     * @param string     $id
     * @param null|mixed $default
     *
*@return \Codex\Core\Menus\Node
     */
    public function get($id, $default = null)
    {
        return $this->items->get($id, $default);
    }

    /**
     * all method
     *
     * @return Node[]
     */
    public function all()
    {
        return $this->items->all();
    }

    /**
     * get view value
     *
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set the view value
     *
     * @param mixed $view
     * @return Menu
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }


    /**
     * Get breadcrumbs to the given Node
     *
     * @param \Codex\Core\Menus\Node $item
     *
*@return array
     */
    public function getBreadcrumbTo(Node $item)
    {
        return $item->getAncestorsAndSelf();
    }

    /**
     * Get breadcrumbs to the Node that has the href
     *
     * @param $href
     * @return array
     */
    public function getBreadcrumbToHref($href)
    {
        $item = $this->findItemByHref($href);
        if ($item) {
            return $this->getBreadcrumbTo($item);
        } else {
            return [ ];
        }
    }

    /**
     * findItemByHref
     *
     * @param $href
     *
*@return \Codex\Core\Menus\Node|null
     */
    public function findItemByHref($href)
    {

        $found = $this->items->filter(function (Node $item) use ($href) {
        

            if ($item->hasAttribute('href') && $item->attribute('href') === $href) {
                return true;
            }
        });
        if ($found->isEmpty()) {
            return null;
        }
        /** @var Node $node */
        $node = $found->first();

        return $node;
    }
}
