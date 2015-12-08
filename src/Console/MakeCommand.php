<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core\Console;

use Docit\Support\Path;
use Docit\Support\Str;
use Docit\Support\StubGenerator;
use Docit\Core\ProjectGenerator;

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

        $name = $this->ask('Directory name');
        $displayName = $this->ask('Display name');

        $name = Str::slugify($name);

        $destPath = Path::join(config('docit.root_dir'), $name);

        $fs = $this->getLaravel()->make('fs');

        if ($fs->exists($destPath)) {
            return $this->error("Could not create $name. Already exists");
        }

        $this->getLaravel()
            ->make(ProjectGenerator::class)
            ->setDestPath($destPath)
            ->generateProject($name, $displayName);

        $this->comment('All done sire!');
    }
}
