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
use Illuminate\Support\Traits\Macroable;

class ListCommand extends Command
{

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
        $table = collect();
        foreach ( codex()->projects->all() as $project ) {
            if ( $this->more ) {
                $table[] = [
                    'Name'         => $project->getName(),
                    'Display name' => $project->getDisplayName(),
                    'Disk driver'  => $project->getDiskConfig()->get('driver'),
                    'Processors'   => implode(', ', $project->config('processors.enabled', [])),
                ];
            } else {
                $this->line(" - {$project->getName()}");
            }
        }
        if ( $this->more ) {
            $this->table(array_keys($table[ 0 ]), $table->map(function ($data) {
                return array_values($data);
            })->toArray());
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
        $table = collect();
        foreach ( codex()->addons->plugins->all() as $plugin ) {
            if ( $this->more ) {
                $table[] = [
                    'Name'        => $plugin->name,
                    'Description' => $plugin->description,
                    'Requires'    => $plugin->requires ? implode(', ', $plugin->requires) : '-',
                    'Replaces'    => $plugin->replace ? $plugin->replace : '-',
                    'Enabled'     => codex()->addons->plugins->canRunPlugin($plugin) ? '<info>Yes</info>' : 'No',
                ];
            } else {
                $this->line(" - {$plugin->name}");
            }
        }
        if ( $this->more ) {
            $this->table(array_keys($table[ 0 ]), $table->map(function ($data) {
                return array_values($data);
            })->toArray());
        }
    }
}
