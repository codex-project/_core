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
namespace Codex\Processors\Macros;

class Table
{
    public function responsive($isCloser = false, $num = null, $str = null, $int = null)
    {
        return $isCloser ? '</div>' : '<div class="responsive">';
    }
}
