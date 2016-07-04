<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */

/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 7/4/16
 * Time: 1:33 AM
 */

namespace Codex\Console;


use Codex\Support\IconGenerator;
use Illuminate\Console\Command;

class IconsCommand extends Command
{
    protected $signature = 'codex:icons';

    protected $description = 'Generate FontAwesome icon as favicon';

    public function handle()
    {
        $generator = app(IconGenerator::class);

        $sizes = [
            16, 32, 64, 128,
            57, 60, 72, 76, 114, 120, 144, 152, 180,
        ];
        $this->comment('Default sizes will be automaticly generatred. (' . implode(',', $sizes) . ')');
        if ( $this->confirm('Are there any more sizes you want to generate? ', false) )
        {
            $sizes = array_merge($sizes, array_map(function ($item)
            {
                return (int)trim($item);
            }, implode(' ', $this->ask('Enter numbers seperated by a space.'))));
        }

        $generator->setSizes($sizes);

        $generator->setIcons($this->ask('Enter icons seperated by a space (ex: book code fork)'));
        $generator->setColors($this->ask('Enter hex colores seperated by a space.'));

        $generator->setOutDir(__DIR__ . '/out');

        $generator->generate();
    }
}
