<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Commands;

use Sebwite\Support\Str;

/**
 * This is the CodexMakeCommand.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class MakeCommand extends BaseCommand
{
    protected $signature = 'codex:make';

    protected $description = 'Create a new codex project';


    public function handle()
    {
        $name        = $this->ask('Directory name');
        $displayName = $this->ask('Display name');
        $name        = Str::slugify($name);

        $this->generate($name, [
            'config.php.stub' => 'config.php'
        ], [
            'displayName' => $displayName
        ]);


        $this->comment('All done sire!');
    }
}
