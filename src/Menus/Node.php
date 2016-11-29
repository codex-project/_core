<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Menus;


use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;

class Node implements Arrayable, NodeInterface
{
    use NodeTrait {
        getParent as _getParent;
        __construct as _con;
    }

    /**
     * @var mixed|null
     */
    protected $id;

    /**
     * @var \Codex\Menu
     */
    protected $menu;

    /**
     * @var array
     */
    protected $meta;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @param mixed|null  $id
     * @param \Codex\Menu $menu
     * @param null        $value
     * @param array       $children
     */
    public function __construct($id, Menu $menu, $value = null, array $children = [])
    {
        $this->_con($value, $children);

        $this->id         = $id;
        $this->menu       = $menu;
        $this->meta       = [];
        $this->attributes = [ 'href' => '#' ];
    }

    /**
     * hasChildren
     *
     * @return bool
     */
    public function hasChildren()
    {
        return count($this->getChildren()) > 0;
    }

    /**
     * attribute
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function attribute($key, $default = null)
    {
        return array_get($this->attributes, $key, $default);
    }

    /**
     * meta
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function meta($key, $default = null)
    {
        return array_get($this->meta, $key, $default);
    }

    /**
     * setAttribute
     *
     * @param      $key
     * @param null $value
     *
     * @return $this
     */
    public function setAttribute($key, $value = null)
    {
        if ( is_array($key) && is_null($value) ) {
            $this->attributes = $key;
        } else {
            array_set($this->attributes, $key, $value);
        }

        return $this;
    }

    /**
     * setMeta
     *
     * @param      $key
     * @param null $value
     *
     * @return $this
     */
    public function setMeta($key, $value = null)
    {
        if ( is_array($key) && is_null($value) ) {
            $this->meta = $key;
        } else {
            array_set($this->meta, $key, $value);
        }

        return $this;
    }

    /**
     * hasMeta
     *
     * @param $key
     *
     * @return bool
     */
    public function hasMeta($key)
    {
        return array_has($this->meta, $key);
    }

    /**
     * get meta value
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * get attributes value
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * parseAttributes
     *
     * @return string
     */
    public function parseAttributes()
    {
        $parsed = '';
        foreach ( $this->attributes as $key => $val ) {
            $parsed .= " {$key}=\"{$val}\"";
        }

        return $parsed;
    }

    /**
     * hasAttribute
     *
     * @param $key
     *
     * @return bool
     */
    public function hasAttribute($key)
    {
        return array_has($this->attributes, $key);
    }

    /**
     * Get the value of id
     *
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id
     *
     * @param mixed|null $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * getParent method
     *
     * @return Node
     */
    public function getParent()
    {
        return $this->_getParent();
    }

    public function hasParent()
    {
        return $this->getParent() !== null;
    }

    /**
     * neighbors method
     *
     * @param bool $self
     *
     * @return \Illuminate\Support\Collection|Node[]
     */
    public function neighbors($self = false)
    {
        return new Collection($self ? $this->getNeighborsAndSelf() : $this->getNeighbors());
    }

    /**
     * children method
     * @return \Illuminate\Support\Collection|Node[]
     */
    public function children()
    {
        return new Collection($this->getChildren());
    }


    public function toArray()
    {
        $children = $this->children();
        return [
            'id'          => $this->id,
            'value'       => $this->getValue(),
            'meta'        => $this->meta,
            'attributes'  => $this->attributes,
            'menu'        => $this->menu->getId(),
            'parent'      => $this->hasParent() ? $this->getParent()->getId() : null,
            'children'    => $children->toArray(),
            'hasChildren' => $children->isEmpty() === false,
        ];
    }
}
