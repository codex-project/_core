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


namespace Codex\Support;


use Laradic\Support\Arr;

class Collection extends \Illuminate\Support\Collection
{
    public function get($key, $default = null)
    {
        $item = data_get($this->items, $key, $default);
        if ( is_array($item) ) {
            return static::make($item);
        }
        return $item;
    }

    /** @return static */
    public function set($key, $value = null)
    {
        data_set($this->items, $key, $value);
        return $this;
    }

    /** @return static */
    public function add($value)
    {
        $this->items[] = $value;
        return $this;
    }

    public function whereHas($key, $value)
    {
        return $this->filter(function ($item) use ($key, $value) {
            return in_array($value, data_get($item, $key, [ ]), true);
        });
    }

    public function has($key)
    {
        return Arr::has($this->items, $key);
    }

    /** @return static */
    public function forget($keys)
    {
        $keys = (array)$keys;
        foreach ( $keys as $key ) {
            $segments = explode('.', $key);
            while ( count($segments) ) {
                $segment = array_shift($segments);
                $last    = count($segments) === 0;
                $item    = &$this->items[ $segment ];
                if ( $last ) {
                    unset($item);
                }
            }
        }
        return $this;
    }

    /**
     * customMerge method
     *
     * @param array      $items
     * @param array|null $key
     * @param string     $method
     *
     * @return Collection
     */
    public function customMerge(array $items, array $key = null, $method = 'array_replace_recursive')
    {
        if ( $key ) {
            $this->set($key, call_user_func($method, $this->get($key, [ ]), $items));
        } else {
            $this->items = call_user_func($method, $this->items, $items);
        }
        return $this;
    }


    /**
     * Get an item at a given offset.
     *
     * @param  mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return data_get($this->items, $key);
    }

    /**
     * Removes all items in this collection
     *
     * @return $this
     */
    public function clear()
    {
        $this->items = [ ];
        return $this;
    }
}
