<?php
namespace Codex\Console;


use Illuminate\Console\Command;

class CreateCommand extends Command
{
    protected $signature = 'codex:create';

    protected $description = 'Create a new project';

    public function handle()
    {
        $gen = codex('projects')->createGenerator();
        $gen->setName($this->ask('Enter name'));
        $gen->set('displayName', $this->ask('Enter display name'));
        $gen->generate();
        $this->comment('done');
    }


}
