<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Traits;

use Codex\Core\Extensions;
use Illuminate\Support\Traits\Macroable;

/**
 * This is the Hookable.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
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
        return Extensions::runHook($name, $params);
    }

    protected function isResponse(&$val)
    {
        if (!is_array($val)) {
            $val = [ $val ];
        }
        foreach ($val as $value) {
            if ($value instanceof \Symfony\Component\HttpFoundation\Response) {
                return $val = $value;
            }
        }

        return false;
    }
}
