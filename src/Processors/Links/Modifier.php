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
namespace Codex\Processors\Links;

class Modifier
{
    protected $name;

    protected $parameters = [];

    /**
     * Modifier constructor.
     *
     * @param       $name
     * @param array $parameters
     */
    public function __construct($name, array $parameters = [])
    {
        $this->name       = $name;
        $this->parameters = $parameters;
    }


    /**
     * hasParameters method
     * @return bool
     */
    public function hasParameters()
    {
        return count($this->parameters) > 0;
    }

    /**
     * param method
     *
     * @param      $i
     * @param null $default
     *
     * @return null
     */
    public function param($i, $default = null)
    {
        return $this->hasParameter($i) ? $this->parameters[ $i ] : $default;
    }

    public function containsParameter($str)
    {
        return in_array($str, $this->parameters, true);
    }

    /**
     * hasParameter method
     *
     * @param $i
     *
     * @return bool
     */
    public function hasParameter($i)
    {
        return isset($this->parameters[ $i ]);
    }

}