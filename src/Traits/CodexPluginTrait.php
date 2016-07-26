<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Traits;

use Sebwite\Support\ServiceProvider;

/**
 * This is the class CodexProviderTrait.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 * @mixin ServiceProvider
 */
trait CodexPluginTrait
{
    protected function projectConfig($config, $method = 'array_replace_recursive')
    {
        $this->addons()->mergeDefaultProjectConfig($config, $method);
    }

    /**
     * addons method
     * @return \Codex\Addons\Factory
     */
    protected function addons()
    {
        return \Codex\Addons\Factory::getInstance();
    }

    protected function documentAttributes($config, $method = 'array_replace_recursive')
    {
        $this->addons()->mergeDefaultDocumentAttributes($config, $method);
    }

    protected function ignoreRoute($route)
    {
        $this->app->make('config')->push('codex.http.ignore_project_names', $route);
    }

    protected function hook($point, $listener)
    {
        return $this->addons()->hook($point, $listener);
    }

    /**
     * codex method
     * @return \Codex\Codex
     */
    protected function codex()
    {
        return $this->app[ 'codex' ];
    }

    /**
     * Register or gets a view name
     *
     * @param string            $key
     * @param null|string|array $value
     *
     * @return string|null
     */
    protected function view($key, $value = null)
    {
        return $this->addons()->view($key, $value);
    }
}
