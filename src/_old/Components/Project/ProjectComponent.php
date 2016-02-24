<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Components\Project;

use BadMethodCallException;
use Codex\Core\Project;
use Sebwite\Support\Traits\Extendable;

/**
 * This is the class ProjectComponent.
 *
 * @package        Codex\Core
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 * @mixin \Codex\Core\Project
 */
class ProjectComponent
{
    use Extendable;

    protected $project;

    /**
     * Component constructor.
     *
     * @param \Sebwite\Workbench\Contracts\Workbench $codex
     */
    public function __construct(Project $parent)
    {
        $this->project = $parent;
    }

    /**
     * getProject method
     *
     * @return \Codex\Core\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    public function getContainer()
    {
        return $this->getProject()->getContainer();
    }


    public function __call($method, $params)
    {
        $project = $this->project;

        if (array_key_exists($method, static::$extensions)) {
            return $this->callExtension($method, $params);
        } elseif (method_exists($project, $method) || array_key_exists($method, $project::extensions())) {
            return call_user_func_array([ $project, $method ], $params);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
