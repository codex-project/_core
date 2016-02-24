<?php
namespace TASDCodex\Core\Traits;

use Codex\Core\Extensions\Extender;

/**
 * Codex hook provider trait
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
trait CodexProviderTrait
{
    /**
     * Add a new factory hook.
     *
     * @param  string                               $hookPoint
     * @param  \Closure|\Codex\Core\Constracts\Hook $handler
     *
*@return void
     */
    protected function codexHook($hookPoint, $handler)
    {
        Extender::addHook($hookPoint, $handler);
    }

    /**
     * Add a new document filter.
     *
     * @param  string                                $name
     * @param  \Closure|\Codex\Core\Contracts\Filter $handler
     *
*@return void
     */
    protected function codexFilter($name, $handler)
    {
        Extender::filter($name, $handler);
    }

    /**
     * addRouteProjectNameExclusions
     *
     * @param string|array $names
     */
    protected function codexRouteExclusion($names)
    {
        Extender::addExcludedProjectNames($names);
    }
}
