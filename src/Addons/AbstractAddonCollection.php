<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Scanner\ClassFileInfo;
use Illuminate\Container\Container;

abstract class AbstractAddonCollection extends \Illuminate\Support\Collection
{
    /** @var Addons */
    protected $addons;

    protected $app;

    public function __construct($items = [ ], $addons = null)
    {
        parent::__construct($items);
        $this->app    = Container::getInstance();
        $this->addons = $addons ?: $this->app->make('codex.addons');
    }

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

    public function whereHas($key, $value)
    {
        return $this->filter(function ($item) use ($key, $value) {
            return in_array($value, data_get($item, $key, [ ]), true);
        });
    }
}