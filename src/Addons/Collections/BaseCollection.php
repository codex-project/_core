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
namespace Codex\Addons\Collections;

use Codex\Addons\Addons;
use Codex\Contracts\Traits\Hookable;
use Laradic\Support\Arr;

abstract class BaseCollection extends \Illuminate\Support\Collection implements Hookable
{

    /** @var Addons */
    protected $addons;

    /** @var \Illuminate\Foundation\Application */
    protected $app;

    public function __construct($items = [ ], $addons = null)
    {
        parent::__construct($items);
        $this->app    = \Illuminate\Foundation\Application::getInstance();
        $this->addons = $addons ?: $this->app->make('codex.addons');
    }

    public function get($key, $default = null)
    {
        return Arr::get($this->items, $key, $default);
    }

    public function set($key, $value = null)
    {
        Arr::set($this->items, $key, $value);
        return $this;
    }


    public function has($key)
    {
        return Arr::has($this->items, $key);
    }

    public function forget($keys)
    {
        Arr::forget($this->items, $keys);
        return $this;
    }

    public function whereHas($key, $value)
    {
        return $this->filter(function ($item) use ($key, $value) {
            return in_array($value, data_get($item, $key, [ ]), true);
        });
    }

    public function offsetExists($key)
    {
        $this->has($key);
    }

    public function offsetGet($key)
    {
        $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetUnset($key)
    {
        $this->forget($key);
    }


}
