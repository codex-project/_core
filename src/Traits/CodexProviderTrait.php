<?php
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
trait CodexProviderTrait
{
    protected function codexProjectConfig($config, $method = 'array_replace_recursive')
    {
        $this->codexAddons()->mergeDefaultProjectConfig($config, $method);
    }

    protected function codexDocumentAttributes($config, $method = 'array_replace_recursive')
    {
        $this->codexAddons()->mergeDefaultDocumentAttributes($config, $method);
    }

    protected function codexIgnoreRoute($route)
    {
        $this->app->make('config')->push('codex.routing.ignore_project_names', $route);
    }

    protected function codexHook($point, $listener)
    {
        $this->codexAddons()->hooks->hook($point, $listener);
    }

    /**
     * codex method
     * @return \Codex\Codex
     */
    protected function codex()
    {
        return $this->app['codex'];
    }

    /**
     * addons method
     * @return \Codex\Addons\Addons
     */
    protected function codexAddons()
    {
        return \Codex\Addons\Addons::getInstance();
    }
}