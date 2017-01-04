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
        foreach (codex('projects')->all() as $project) {
            # $content = $project->documents->get('asdf')->render();
            $this->line(" - {$project->getName()}");
        }
    }

    protected function listFilters()
    {
        foreach (codex('addons')->processors->all() as $filter) {
            if ($this->more) {
                $replace = $filter[ 'replace' ] ? "\nReplaces: {$filter['replace']}\n" : '';

                $this->output->write(<<<FILTER
<comment>{$filter['name']}</comment>
Priority: {$filter['priority']}{$replace}


FILTER
                );
            } else {
                $this->line(" - {$filter['name']}");
            }
        }
    }
}
