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

trait CreateDomElementTrait
{
    /**
     * Create a dom element. Cast to string to get the HTML.
     *
     * @param       $name
     * @param array $attrs
     *
     * @return \FluentDOM\Element
     */
    protected function createElement($name, $attrs = [ ])
    {
        $el = \FluentDOM::create()->element($name);
        foreach ($attrs as $k => $v) {
            $el->setAttribute($k, $v);
        }
        return $el;
    }
}
