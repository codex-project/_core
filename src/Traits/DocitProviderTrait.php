<?php
namespace Docit\Core\Traits;

use Docit\Core\Extensions;

/**
 * Docit hook provider trait
 *
 * @package   Docit\Core
 * @author    Docit Project Dev Team
 * @copyright Copyright (c) 2015, Docit Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
trait DocitProviderTrait
{
    /**
     * Add a new factory hook.
     *
     * @param  string                                $hookPoint
     * @param  \Closure|\Docit\Core\Constracts\Hook $handler
     * @return void
     */
    protected function addDocitHook($hookPoint, $handler)
    {
        Extensions::addHook($hookPoint, $handler);
    }

    /**
     * Add a new document filter.
     *
     * @param  string                                 $name
     * @param  \Closure|\Docit\Core\Contracts\Filter $handler
     * @return void
     */
    protected function addDocitFilter($name, $handler)
    {
        Extensions::filter($name, $handler);
    }

    /**
     * addRouteProjectNameExclusions
     *
     * @param string|array $names
     */
    protected function addRouteProjectNameExclusions($names)
    {
        Extensions::addExcludedProjectNames($names);
    }
}
