<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core\Console;

use Docit\Support\Str;

/**
 * This is the DocitMakeCommand.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class MakeCommand extends BaseCommand
{
    protected $signature = 'docit:make';

    protected $description = 'Create a new docit project';


    public function handle()
    {
        $name        = $this->ask('Directory name');
        $displayName = $this->ask('Display name');
        $name        = Str::slugify($name);

        $this->generate($name, [
            'config.php.stub' => 'config.php',
            'index.md.stub'   => '{{directory}}/index.md',
            'menu.yml.stub'   => '{{directory}}/menu.yml'
        ], [
            'displayName' => $displayName
        ]);


        $this->comment('All done sire!');
    }
}
