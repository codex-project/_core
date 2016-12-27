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
namespace Codex\Addons;

use Laradic\Support\Arr;

class Manifest extends \Illuminate\Support\Collection
{
    /** @var string */
    protected $manifestPath;

    /**
     * Manifest constructor.
     *
     * @param string                         $manifestPath
     * @param \Laradic\Filesystem\Filesystem $fs
     */
    public function __construct($items = [])
    {
        parent::__construct($items);
    }

    /**
     * @param array $items
     *
     * @return \Codex\Addons\Manifest
     *
     */
    public static function make($items = [ ])
    {
        return parent::make($items);
    }

    public function value()
    {
        return $this->items[ 0 ];
    }

    /** @return static */
    public function clear()
    {
        $this->items = [ ];
        return $this;
    }

    /** @return static */
    public function load()
    {
        $manifest    = file_get_contents($this->getManifestPath());
        $this->items = json_decode($manifest, true);
        return $this;
    }

    /**
     * @param int $options
     *
     * @return static
     */
    public function save($options = JSON_UNESCAPED_SLASHES)
    {
        $manifest = json_encode($this->items, $options);
        file_put_contents($this->getManifestPath(), $manifest);
        return $this;
    }

    /**
     * @param $value
     *
     * @return static
     */
    public function add($value)
    {
        $this->items[] = $value;
        return $this;
    }

    public function has($key)
    {
        return Arr::has($this->items, $key);
    }

    public function get($key, $default = null)
    {
        return data_get($this->items, $key, $default);
    }

    /**
     * @param      $key
     * @param null $value
     *
     * @return static
     */
    public function set($key, $value = null)
    {
        if ( $value === null )
        {
            $this->customMerge($key);
        }
        else
        {
            data_set($this->items, $key, $value);
        }
        return $this;
    }

    /**
     * @param array $keys
     *
     * @return static
     */
    public function forget($keys = [ ])
    {
        Arr::forget($this->items, $keys);
        return $this;
    }

    public function whereHas($key, $value)
    {
        return $this->filter(function ($item) use ($key, $value)
        {
            return in_array($value, data_get($item, $key, [ ]), true);
        });
    }

    /**
     * @param array  $items
     * @param array  $key
     * @param string $method
     *
     * @return static
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

    public function getManifestPath()
    {
        return $this->manifestPath ?: config('codex.paths.manifest', storage_path('codex.json'));
    }

    /**
     * Set the manifestPath value
     *
     * @param string $manifestPath
     *
     * @return static
     */
    public function setManifestPath($manifestPath)
    {
        $this->manifestPath = $manifestPath;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($key)
    {
        $this->forget($key);
    }


}
