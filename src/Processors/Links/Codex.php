<?php
namespace Codex\Processors\Links;

class Codex
{
    public function confirm()
    {
    }

    public function project(Action $action)
    {

        if ( false === codex('projects')->has($action->param(0)) )
        {
            return;
        }
        $project = codex('projects')->get($action->param(0));


        if ( $action->hasParameter(1) && false === $project->hasRef($action->param(1)) )
        {
            return;
        }

        $url = codex()->url($project, $action->param(1), $action->param(2));

        $action->getElement()->setAttribute('href', $url);
    }
}