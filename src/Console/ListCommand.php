<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Console;

use Codex\Codex;
use Illuminate\Console\Command;
use Illuminate\Support\Traits\Macroable;

class ListCommand extends Command
{
    use Macroable;

    protected $signature = 'codex:list {what=projects} {--more}';

    protected $description = 'List all projects, processors and whatnot';

    protected $more = false;

    protected $enabled = false;

    public function handle()
    {
        $what       = $this->argument('what');
        $this->more = $this->option('more');

        call_user_func([ $this, 'list' . studly_case($what) ]);
    }

    protected function listProjects()
    {
        $this->line("<info>Projects</info>");
        foreach ( codex()->projects->all() as $project ) {
            # $content = $project->documents->get('asdf')->render();
            $this->line(" - {$project->getName()}");
        }
    }

    protected function listProcessors()
    {
        $this->line("<info>Processors</info>");
        $rows = [];
        foreach ( codex()->addons->processors->all() as $processor ) {
            if ( $this->more ) {
                $rows[] = [
                    $processor->name,
                    implode(', ', $processor->depends),
                    implode(', ', $processor->after),
                    implode(', ', $processor->before),
                    $processor->replace ?: '',
                ];
            } else {
                $this->line(" - {$processor['name']}");
            }
        }
        if ( $this->more ) {
            $this->table([ 'Name', 'Depends', 'After', 'Before', 'Replace' ], $rows);
        }
    }

    protected function listPlugins()
    {
        $this->line("<info>Plugins</info>");
        foreach ( codex()->addons->plugins->all() as $plugin ) {
            if ( $this->more ) {

                $this->line(" - {$plugin['name']}");
            } else {
                $this->line(" - {$plugin->name}");
            }
        }
    }
}
