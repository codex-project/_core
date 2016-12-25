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
namespace Codex\Console;


use Codex\Projects\Project;

class ProjectsShowCommand extends Command
{

    protected $signature = 'codex:projects:show {name?} {--config}';

    protected $description = 'Show information of a project';

    public function handle()
    {
        $projects = codex('projects');
        $name     = $this->argument('name');
        if ( !$name ) {
            $choices = $projects->getItems()->keys()->toArray();
            $choices = array_combine($choices, $choices);
            $name    = $this->choice('name', $choices);
        }
        if ( !$projects->has($name) ) {
            return $this->error('Project does not exist');
        }
        $this->showProject($name);
    }

    protected function showProject($project)
    {
        if ( !$project instanceof Project ) {
            $project = codex('projects')->get($project);
        }
        $description = "<comment>{$project->config('description', '')}</comment>";
        $processors = implode(', ', $project->config('processors.enabled', []));
        $refs       = implode(', ', $project->refs->getSorted());

        $lines = str_repeat('-', strlen($project->getDisplayName()));
        $this->line(<<<EOL
--$lines--
| <info>{$project->getDisplayName()}</info> |
--$lines--
<info>Name</info>                   : {$project->getName()}
<info>Description</info>            : {$project->config('description', '')}
<info>Display name</info>           : {$project->getDisplayName()}
<info>Default ref</info>            : {$project->refs->getDefaultName()}
<info>Sorted refs</info>            : {$refs}
<info>Processors</info>             : {$processors}
<info>Path</info>                   : {$project->getPath()}
<info>Disk driver</info>            : {$project->getDiskConfig()->get('driver')}
<info>Disk root</info>              : {$project->getDiskConfig()->get('root')}
EOL
        );
    }
}
