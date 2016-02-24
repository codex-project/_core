<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Components\Menu;

use Codex\Core\Menu;

/**
 * This is the Node.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class Node extends \Tree\Node\Node
{
    /**
     * @var mixed|null
     */
    protected $id;

    /**
     * @var \Codex\Core\Menu
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
     * @param mixed|null       $id
     * @param \Codex\Core\Menu $menu
     * @param null             $value
     * @param array            $children
     */
    public function __construct($id, Menu $menu, $value = null, array $children = [ ])
    {
        parent::__construct($value, $children);

        $this->id         = $id;
        $this->menu       = $menu;
        $this->meta       = [ ];
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
     * @return $this
     */
    public function setAttribute($key, $value = null)
    {
        if (is_array($key) && is_null($value)) {
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
     * @return $this
     */
    public function setMeta($key, $value = null)
    {
        if (is_array($key) && is_null($value)) {
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
        foreach ($this->attributes as $key => $val) {
            $parsed .= " {$key}=\"{$val}\"";
        }

        return $parsed;
    }

    /**
     * hasAttribute
     *
     * @param $key
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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
