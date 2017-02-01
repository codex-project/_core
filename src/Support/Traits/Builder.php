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
namespace Codex\Support\Traits;

use Illuminate\Container\Container;

trait Builder
{
    public function build(string $class, array $params = [])
    {
        $container = Container::getInstance();
        foreach($params as $key => $value) {
            $container->when($class)->needs(str_ensure_left($key, '$'))->give($value);
        }
        return $container->build($class);
    }
}