<?php
/**
 * Part of the Docit PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Traits;

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
        if ( !isset($this->container) ) {
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
