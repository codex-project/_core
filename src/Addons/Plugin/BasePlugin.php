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
namespace Codex\Addons\Plugin;

abstract class BasePlugin implements PluginInterface
{
    /**
     * The Container instance
     * @var \Illuminate\Contracts\Foundation\Application
     */
    public $app;

    /**
     * The main Codex instance
     * @var \Codex\Codex
     */
    public $codex;

    /** @var \Codex\Addons\Factory */
    public $addons;

    /**
     * Initially, this is the default configuration of the plugin. When the enable function is executed, this is replaced by (possible) user overides.
     *
     * @var \Codex\Support\Collection|array|string
     */
    public $config = [ ];

    /**
     * Any view files used in Plugins should be registered this way.
     * You can register Codex view files.
     * You can overide other Codex views or any plugin views this plugin depends on.
     *
     * @var array
     */
    public $views = [ ];

    /**
     * If this Plugin is enabled, these ServiceProviders will be registered and booted as well
     *
     * @var \Illuminate\Support\ServiceProvider[]|array
     */
    public $providers = [ ];

    public abstract function enable();

    protected function hook($name, $handler)
    {
        $this->addons->hooks->hook($name, $handler);
    }

    protected function projectConfig($config, $method = 'array_replace_recursive')
    {
        $this->addons->mergeDefaultProjectConfig($config, $method);
    }

    protected function documentAttributes($config, $method = 'array_replace_recursive')
    {
        $this->addons->mergeDefaultDocumentAttributes($config, $method);
    }

}