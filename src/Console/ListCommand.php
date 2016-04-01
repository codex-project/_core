<?php
namespace Codex\Core\Console;

use Codex\Console\Commands\Command;

class ListCommand extends Command
{
    protected $signature = 'codex:list';

    public function handle()
    {
        foreach(codex('projects')->all() as $project) {
           # $content = $project->documents->get('asdf')->render();
            $this->line(" - {$project->getName()}");
        }
    }
}
