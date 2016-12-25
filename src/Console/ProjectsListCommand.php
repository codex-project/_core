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


class ProjectsListCommand extends Command
{

    protected $signature = 'codex:projects:list {--detailed}';

    protected $description = 'List all projects, processors and whatnot';

    public function handle()
    {
        return $this->option('detailed') ? $this->listDetailed() : $this->list();
    }

    protected function list()
    {
        foreach ( codex('projects')->all() as $project ) {
            $this->line("- {$project->getName()}");
        }
    }

    public function listDetailed()
    {
        $table = collect();
        foreach ( codex('projects')->all() as $project ) {
            $project->config('processors.enabled', []);

            $table[] = [
                'Name'         => $project->getName(),
                'Display name' => $project->getDisplayName(),
                'Disk driver'  => $project->getDiskConfig()->get('driver'),
                'Processors'   => implode(', ', $project->config('processors.enabled', [])),
            ];
        }

        $this->table(array_keys($table[ 0 ]), $table->map(function ($data) {
            return array_values($data);
        })->toArray());
    }
}
