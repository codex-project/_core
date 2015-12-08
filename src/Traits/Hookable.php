<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core\Traits;

use Docit\Core\Extensions;
use Illuminate\Support\Traits\Macroable;

/**
 * This is the Hookable.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
trait Hookable
{
    use Macroable;

    /**
     * Run a hook
     *
     * @param       $name
     * @param array $params
     */
    protected function runHook($name, array $params = [ ])
    {
        Extensions::runHook($name, $params);
    }
}
