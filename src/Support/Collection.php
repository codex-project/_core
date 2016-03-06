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
        if(is_array($item)){
            return static::make($item);
        }
        return $item;
    }
}
