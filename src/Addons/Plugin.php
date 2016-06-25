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

abstract class Plugin
{
    /** @var \Illuminate\Contracts\Foundation\Application */
    public $app;

    /** @var */
    public $codex;

    /** @var \Codex\Addons\Factory */
    public $addons;

    /** @var \Codex\Support\Collection|array|string */
    public $config = [ ];

    /** @var array */
    public $views = [ ];

    /** @var \Illuminate\Support\ServiceProvider[]|array */
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