<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Support\Traits;

use Codex\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;

/**
 * The ConfigTrait provides a class with a config method to request the set config. Also provides getter/setter for that.
 *
 * @package        Codex\Core
 * @author         Docit
 * @copyright      Copyright (c) 2015, Docit. All rights reserved
 */
trait ConfigTrait
{
    /**
     * The config array
     *
     * @var array
     */
    protected $config = [];

    /**
     * Get a configuration item of the project using dot notation
     *
     * @param null|string $key
     * @param null|mixed  $default
     *
     * @return array|mixed|Collection
     */
    public function config($key = null, $default = null)
    {
        return $key === null ? new Collection($this->config) : data_get($this->config, $key, $default);
    }

    /**
     * Set the config.
     *
     * @param array|Arrayable|string $key The string key to set the value to. Or to set the whole config, you can pass a array or Arrayable without value
     * @param null|mixed             $value
     *
     * @return $this
     *
     */
    public function setConfig($key, $value = null)
    {
        if ($value === null) {
            if ($key instanceof Arrayable) {
                $key = $key->toArray();
            }
            if (is_array($key)) {
                $this->config = $key;
            }
        } else {
            array_set($this->config, $key, $value);
        }

        return $this;
    }

    /**
     * get config value
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function mergeConfig($items, $key = null, $method = 'array_replace_recursive')
    {
        if($items instanceof Arrayable){
            $items = $items->toArray();
        }
        $this->config = $this->config()->customMerge($items, $key, $method)->toArray();
    }
}
