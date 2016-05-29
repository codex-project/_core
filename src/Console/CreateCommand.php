<?php
namespace Codex\Core\Console;


use Illuminate\Console\Command;

class CreateCommand extends Command
{
    protected $signature = 'codex:create {name}';

    protected $description = 'Create a new project';

    public function handle()
    {
        $this->error('Not yet implemented');
    }


}
