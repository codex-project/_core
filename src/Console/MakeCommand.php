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

use Illuminate\Console\Command;

class MakeCommand extends Command
{
    protected $signature = 'codex:make {what?}';

    public function handle()
    {
        $this->choice('What to make?', ['project', 'processor', 'hook', 'plugin', 'addon']);
    }
}
