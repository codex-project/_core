<?php
namespace Codex\Console;


use Codex\Projects\ProjectGenerator;
use Illuminate\Console\Command;

class CreateCommand extends Command
{
    protected $signature = 'codex:create';

    protected $description = 'Create a new project';

    public function handle()
    {
        $gen = app()->make(ProjectGenerator::class);
        $gen->setName($this->ask('Enter name'));
        $gen->set('displayName', $this->ask('Enter display name'));
        $gen->generate();
        $this->comment('done');
    }


}
