<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Support;


class Collection extends \Illuminate\Support\Collection
{
    public function get($key, $default = null)
    {
        $item = data_get($this->items, $key, $default);
        if ( is_array($item) )
        {
            return static::make($item);
        }
        return $item;
    }

    public function set($key, $value = null)
    {
        data_set($this->items, $key, $value);
    }

    public function add($value)
    {
        $this->items[] = $value;
    }

    public function whereHas($key, $value)
    {
        return $this->filter(function ($item) use ($key, $value)
        {
            return in_array($value, data_get($item, $key, [ ]), true);
        });
    }

    public function forget($keys)
    {
        $keys = (array)$keys;
        foreach ( $keys as $key )
        {
            $segments = explode('.', $key);
            while ( count($segments) )
            {
                $segment = array_shift($segments);
                $last    = count($segments) === 0;
                $item    = &$this->items[ $segment ];
                if ( $last )
                {
                    unset($item);
                }
            }
        }
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
        if ( $key )
        {
            $this->set($key, call_user_func($method, $this->get($key, [ ]), $items));
        }
        else
        {
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
}
