<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Support;


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
        return $this->filter(function ($item) use ($key, $value) {
            return in_array($value, data_get($item, $key, [ ]), true);
        });
    }

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
    }
}
