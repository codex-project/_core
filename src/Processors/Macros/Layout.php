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
namespace Codex\Processors\Macros;

class Layout
{

    public function row($isCloser = false)
    {
        return $isCloser ? '</div>' : '<div class="row">';
    }

    public function column($isCloser = false, $breakpoint = 'sm', $width = '12')
    {
        $class = "col-{$breakpoint}-{$width}";
        return $isCloser ? '</div>' : "<div class=\"{$class}\">";
    }
}