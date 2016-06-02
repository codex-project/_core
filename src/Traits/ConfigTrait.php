<?php
/**
 * Part of the Docit PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Traits;

/**
 * This is the class ConfigTrait.
 *
 * @package        Codex\Core
 * @author         Docit
 * @copyright      Copyright (c) 2015, Docit. All rights reserved
 */
trait ConfigTrait
{
    protected $config;

    /**
     * Get a configuration item of the project using dot notation
     *
     * @param null|string $key
     * @param null|mixed  $default
     *
     * @return array|mixed
     */
    public function config($key = null, $default = null)
    {
        return $key === null ? $this->config : data_get($this->config, $key, $default);
    }

    /**
     * Set the config.
     *
     * @param  array $config
     *
     * @return void
     */
    public function setConfig($key, $value = null)
    {
        if ($value === null && is_array($key)) {
            $this->config = $key;
        } else {
            array_set($this->config, $key, $value);
        }

        return $this;
    }

    /**
     * get config value
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }
}
