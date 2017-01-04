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
namespace Codex\Processors\Links;

class Codex
{
    public function confirm()
    {
    }

    public function project(Action $action)
    {

        if (false === codex('projects')->has($action->param(0))) {
            return;
        }
        $project = codex('projects')->get($action->param(0));


        if ($action->hasParameter(1) && false === $project->hasRef($action->param(1))) {
            return;
        }

        $url = codex()->url($project, $action->param(1), $action->param(2));

        $action->getElement()->setAttribute('href', $url);
    }
}
