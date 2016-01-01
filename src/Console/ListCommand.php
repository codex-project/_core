<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Console;

/**
 * This is the CodexMakeCommand.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class ListCommand extends BaseCommand
{
    protected $signature = 'codex:list';

    protected $description = 'List all codex projects';

    public function handle()
    {
        $headers = ['Name', 'Display name', 'Ref'];
        $rows = [];
        foreach ( $this->codex->getProjects() as $project) {
            $rows[] = [$project->getName(), $project->config('display_name'), $project->getRef()];
        }
        $this->table($headers, $rows);
    }
}
