<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Menus;

use Codex\Contracts;
use Illuminate\Support\Collection;
use Codex\Support\Extendable;
use Codex\Support\Traits\AttributesTrait;
use Codex\Support\Traits\ConfigTrait;
use Codex\Support\Traits\FilesTrait;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Router;
use Laradic\Filesystem\Filesystem;
use Tree\Visitor\PostOrderVisitor;
use Tree\Visitor\PreOrderVisitor;
use Tree\Visitor\Visitor;

class Menu extends Extendable implements Arrayable, Contracts\Menus\Menu
{
    use FilesTrait,
        ConfigTrait,
        AttributesTrait;

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
     * @var \Illuminate\Support\Collection|Node[]
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

    protected $resolver;

    protected $resolved = false;

    protected $rendered;


    /**
     * @param \Codex\Contracts\Menus\Menus|\Codex\Menus\Menus                         $menus
     * @param \Illuminate\Contracts\Filesystem\Filesystem                             $files
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
        $this->view        = $menus->getCodex()->view('menus.default');
        $this->items       = new Collection();
        $this->attributes  = [
            'title' => '',
        ];

        $this->hookPoint('menu:construct', [ $id ]);

        $this->items->put('root', new Node('root', $this, 'root'));

        $this->hookPoint('menu:constructed', [ $id ]);
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
    public function add($id, $value, $parent = 'root', array $meta = [], array $attributes = [])
    {
        $node = new Node($id, $this, $value);
        $node->setMeta($meta);
        $node->setAttribute($attributes);

        if ( $this->items->has($parent) ) {
            $parentNode = $this->items->get($parent);
            $parentNode->addChild($node);
//            $node->setParent($parentNode);
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
     * @return \Codex\Menus\Node
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
     * Clears the menu, removes all the items and children
     *
     * @param bool $root =false If true, it will remove the rood node from the menu as well. False by default
     *
     * @return $this
     */
    public function clear($root = false)
    {
        $rootNode = $this->getRootNode();
        $rootNode->removeAllChildren();
        $this->items = new Collection();
        if ( false === $root ) {
            $this->items->put('root', $rootNode);
        }
        return $this;
    }

    /**
     * Get breadcrumbs to the given Node
     *
     * @param \Codex\Menus\Node $item
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
        if ( $item ) {
            return $this->getBreadcrumbTo($item);
        } else {
            return [];
        }
    }

    /**
     * findItemByHref
     *
     * @param $href
     *
     * @return \Codex\Menus\Node|null
     */
    public function findItemByHref($href)
    {
        /** @var Collection $found */
        $found = $this->items->filter(function (Node $item) use ($href) {
            if ( $item->hasAttribute('href') && $item->attribute('href') === $href ) {
                return true;
            }
        });

        if ( $found->isEmpty() ) {
            return null;
        }

        return $found->first();
    }

    /**
     * hasResolver method
     *
     * @return bool
     */
    public function hasResolver()
    {
        return null !== $this->resolver;
    }

    /**
     * resolve method
     *
     * @param array $params
     *
     * @return $this
     * @throws \Codex\Exception\CodexException
     */
    public function resolve(array $params = [])
    {
        if ( null === $this->resolver || true === $this->resolved ) {
            return $this;
        }

        /** @var Contracts\Menus\MenuResolver $resolver */
        $resolver = $this->getContainer()->make($this->resolver);
        $this->hookPoint('menu:resolve', [ $resolver ]);
        $this->resolved = true;
        call_user_func_array([ $resolver, 'handle' ], array_merge([ $this ], $params));
        $this->hookPoint('menu:resolved');


        return $this;
    }

    /**
     * Renders the menu using the defined view
     *
     * @param mixed $_
     *
     * @return string
     * @throws \Codex\Exception\CodexException
     */
    public function render()
    {
        $params = func_get_args();
        if ( $this->rendered === null ) {
            $this->resolve($params);
            $this->hookPoint('menu:render');

            $root = $this->getRootNode();
            if ( $this->sorter ) {
                $items = $root->accept(new $this->sorter);
            } else {
                $items = $root->getChildren();
            }

            $vars = [
                'menu'  => $this,
                'items' => $items,
            ];


            $this->rendered = $this->viewFactory->make($this->view)->with($vars)->render();

            $this->hookPoint('menu:rendered', [ $items, $this->rendered ]);
        }
        return $this->rendered;
    }

    /**
     * Set the resolver value
     *
     * @param mixed $resolver
     *
     * @return Menu
     */
    public function setResolver($resolver)
    {
        $this->resolver = $resolver;

        return $this;
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
     * getRootNode method
     *
     * @return Node
     */
    public function getRootNode()
    {
        return $this->items->get('root');
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
        $this->render('sdf', 'sadf');
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'         => $this->id,
            'view'       => $this->view,
            'attributes' => $this->attributes,
            'tree'       => $this->toArrayTree(),
            'items'      => $this->items->values()->toArray(),
        ];
    }

    public function toArrayTree()
    {
        return $this->getRootNode()->toArray();
    }



}
