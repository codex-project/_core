<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core\Console;

/**
 * This is the DocitMakeCommand.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class ListCommand extends BaseCommand
{
    protected $signature = 'docit:list';

    protected $description = 'List all docit projects';

    public function handle()
    {
        $headers = ['Name', 'Display name', 'Ref'];
        $rows = [];
        foreach ($this->factory->getProjects() as $project) {
            $rows[] = [$project->getName(), $project->config('display_name'), $project->getRef()];
        }
        $this->table($headers, $rows);
    }
}
