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
namespace Codex\Support\Traits;

use Illuminate\Contracts\Container\Container;

trait ContainerTrait
{
    /**
     * The IoC container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * The IoC container instance.
     *
     * @var \Illuminate\Container\Container|\Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Returns the IoC container.
     *
     * @return \Illuminate\Container\Container
     */
    public function getContainer()
    {
        if (!isset($this->container)) {
            $this->app = $this->container = \Illuminate\Container\Container::getInstance();
        }
        return $this->container;
    }

    /**
     * Sets the IoC container instance.
     *
     * @param  \Illuminate\Container\Container $container
     *
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        $this->app = $container;

        return $this;
    }
}
