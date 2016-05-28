<?php
namespace Codex\Core\Console;


use Sebwite\Console\Command;

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
