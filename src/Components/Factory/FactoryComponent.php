<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Components\Factory;

use BadMethodCallException;
use Codex\Core\Contracts\Codex;
use Illuminate\Contracts\Container\Container;
use Sebwite\Support\Traits\Extendable;

/**
 * This is the class CodexComponent.
 *
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
abstract class FactoryComponent
{
    use Extendable;

    /**
     * @var \Codex\Core\Factory
     */
    protected $codex;

    /**
     * CodexComponent constructor.
     *
     * @param \Codex\Core\Factory $parent
     */
    public function __construct(Codex $parent)
    {
        $this->codex = $parent;
    }

    /**
     * @return Codex
     */
    public function getCodex()
    {
        return $this->codex;
    }

    /**
     * getContainer method
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->getCodex()->getContainer();
    }


    public function __call($method, $params)
    {
        $wb = $this->codex;

        if (array_key_exists($method, static::$extensions)) {
            return $this->callExtension($method, $params);
        } elseif (method_exists($wb, $method) || array_key_exists($method, $wb::extensions())) {
            return call_user_func_array([ $wb, $method ], $params);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
