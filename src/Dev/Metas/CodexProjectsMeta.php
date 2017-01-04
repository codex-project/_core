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
namespace Codex\Dev\Metas;

use Laradic\Idea\Metadata\Metas\BaseMeta;

class CodexProjectsMeta extends BaseMeta
{
    protected $methods = [
        'new \\Codex\\Projects\\Projects',
        '\\Codex\\Projects\\Projects::get(\'\')',
    ];

    public function getData()
    {
        $projects = [ ];
        /** @var \Codex\Codex $codex */
        $codex = app('Codex\Codex');
        foreach ($codex->projects->all() as $project) {
            /** @var \Codex\Projects\Project $project */
            $projects[ $project->getName() ] = 'Codex\Projects\Project';
        }

        return $projects;
    }


    public static function canRun()
    {
        return true;
    }
}
