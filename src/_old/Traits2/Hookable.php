<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace TASDCodex\Core\Traits;

use Codex\Core\Extensions\Extender;

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
    public function fire($event)
    {
        app('events')->fire('codex.' . $event, [$this]);
    }

    /**
     * Run a hook
     *
     * @param       $name
     * @param array $params
     */
    protected function runHook($name, array $params = [ ])
    {
        return Extender::runHook($name, $params);
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
