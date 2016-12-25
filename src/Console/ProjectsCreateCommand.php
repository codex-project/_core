<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Console;


class ProjectsCreateCommand extends Command
{

    protected $signature = 'codex:projects:create {displayName?} {--examples}';

    protected $description = 'Create a new project';

    public function handle()
    {
        $gen = codex('projects')->createGenerator();
        $displayName = $this->argument('displayName');
        $gen->setName($this->ask('Enter name'));
        $gen->set('displayName', $this->ask('Enter display name'));
        $gen->generate();
        $this->comment('done');
    }
}
