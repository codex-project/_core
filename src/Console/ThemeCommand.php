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

use Codex\Helpers\ThemesHelper;
use Laradic\Console\Command;

class ThemeCommand extends Command
{
    protected $signature = 'codex:theme {--publish=true}';

    protected $description = 'Theme operations';

    public function handle()
    {
        if($this->option('publish')){
            return $this->publish();
        }
    }

    private function publish()
    {
        $themes = app(ThemesHelper::class, []);
        $theme = $themes->get($this->option('publish'));
    }
}
