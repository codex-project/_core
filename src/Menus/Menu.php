<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Menus;

use Codex\Contracts;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Traits;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Router;
use Sebwite\Filesystem\Filesystem;
use Tree\Visitor\PostOrderVisitor;
use Tree\Visitor\PreOrderVisitor;
use Tree\Visitor\Visitor;

class Menu extends Extendable implements Arrayable
{
    use Traits\FilesTrait,
        Traits\ConfigTrait,
        Traits\AttributesTrait;

    const SORTER_PREORDER = PreOrderVisitor::class;

    const SORTER_POSTORDER = PostOrderVisitor::class;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

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
     * @var \Codex\Menus\Menu
     */
    protected $menus;

    /** @var string */
    protected $id;

    /** @var null|Visitor */
    protected $sorter;


    /**
     * @param \Codex\Contracts\Menus\MenuFactory|\Codex\Menus\Menus                   $menus
     * @param \Illuminate\Contracts\Filesystem\Filesystem|\Sebwite\Support\Filesystem $files
     * @param \Illuminate\Contracts\Cache\Repository                                  $cache
     * @param \Illuminate\Routing\Router                                              $router
     * @param \Illuminate\Contracts\Routing\UrlGenerator                              $url
     * @param \Illuminate\Contracts\View\Factory                                      $viewFactory
     * @param                                                                         $id
     */
    public function __construct(Menus $menus, Filesystem $files, Cache $cache, Router $router, UrlGenerator $url, ViewFactory $viewFactory, $id)
    {
        $this->menus       = $menus;
        $this->cache       = $cache;
        $this->router      = $router;
        $this->url         = $url;
        $this->files       = $files;
        $this->viewFactory = $viewFactory;
        $this->id          = $id;
        $this->view        = $menus->getCodex()->view("menus.{$id}");
        $this->items       = new Collection();
        $this->attributes  = [
            'title' => '',
        ];

        $this->hookPoint('menu:construct', [ $id ]);

        $this->items->put('root', new Node('root', $this, 'root'));

        $this->hookPoint('menu:constructed', [ $id ]);
    }

    /**
     * @return mixed
     */
    public function getSorter()
    {
        return $this->sorter;
    }

    /**
     * Set the sorter value
     *
     * @param mixed $sorter
     */
    public function setSorter($sorter)
    {
        $this->sorter = $sorter;
    }

    /**
     * Renders the menu using the defined view
     *
     * @return string
     */
    public function render($sorter = null)
    {
        /** @var Node $root */
        $root   = $this->get('root');
        $sorter = $sorter ?: $this->sorter;

        $this->hookPoint('menu:render', [ $root, $sorter ]);

        if ( $sorter )
        {
            $items = $root->accept(new $sorter);
        }
        else
        {
            $items = $root->getChildren();
        }

        $vars = [
            'menu'  => $this,
            'items' => $items,
        ];


        $rendered = $this->viewFactory->make($this->view)->with($vars)->render();

        $this->hookPoint('menu:rendered', [ $items, $sorter, $rendered ]);

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
     * @return \Codex\Menus\Node
     */
    public function add($id, $value, $parent = 'root', array $meta = [ ], array $attributes = [ ])
    {
        $node = new Node($id, $this, $value);
        $node->setMeta($meta);
        $node->setAttribute($attributes);

        if ( ! is_null($parent) and $this->items->has($parent) )
        {
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
     *
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
     * @return \Codex\Components\Menu\Node
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
     *
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
     * @param \Codex\Components\Menu\Node $item
     *
     * @return array
     */
    public function getBreadcrumbTo(Node $item)
    {
        return $item->getAncestorsAndSelf();
    }

    /**
     * Get breadcrumbs to the Node that has the href
     *
     * @param $href
     *
     * @return array
     */
    public function getBreadcrumbToHref($href)
    {
        $item = $this->findItemByHref($href);
        if ( $item )
        {
            return $this->getBreadcrumbTo($item);
        }
        else
        {
            return [ ];
        }
    }

    /**
     * findItemByHref
     *
     * @param $href
     *
     * @return \Codex\Components\Menu\Node|null
     */
    public function findItemByHref($href)
    {

        $found = $this->items->filter(function (Node $item) use ($href)
        {
            if ( $item->hasAttribute('href') && $item->attribute('href') === $href )
            {
                return true;
            }
        });
        if ( $found->isEmpty() )
        {
            return null;
        }
        /** @var Node $node */
        $node = $found->first();

        return $node;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id value
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'attributes' => $this->attributes,
            'items'      => $this->items->toArray(),
            'id'         => $this->id,
            'view'       => $this->view,
        ];
    }
}
