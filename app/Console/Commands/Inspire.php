<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $git = app('sebwite.git');

        /**
         * @var \Sebwite\Git\Remotes\Remote $bb
         */
        $bb = $git->connection('bitbucket');

        $sw = $bb->listWebhooks('sebwite-git', 'sebwitepackages');

        $gh = $git->connection('github');

        $be = $gh->listWebhooks('blade-extensions', 'robinradic');

        $hook = [
            'description' => 'Webhook Description',
            'url'         => 'http://requestb.in/xxx',
            'active'      => true,
            'events'      => [
                'repo:push'
            ]
        ];

        $bb->createWebhook('sebwite-git', $hook, 'sebwitepackages');

        $a = 'a;';
    }

    protected function phpRunConfig()
    {
//        $phpstorm  = $this->getLaravel()->make('phpstorm');
//        $workspace = $phpstorm->workspace();
//        $has       = $workspace->hasRunConfig('phpstorm:meta');
//        $workspace->addPhpRunConfig('phpstorm:meta', base_path('artisan'), 'phpstorm:meta');
//        $has2 = $workspace->hasRunConfig('phpstorm:meta');
//        $workspace->save();
    }

    protected function vcs()
    {

        $phpstorm = $this->getLaravel()->make('phpstorm');
        $vcs      = $phpstorm->vcs();
        $mappings = $vcs->all();
        $vcs->add('workbench/docit/bitbucket-hook');
        $has = $vcs->has('workbench/docit/bitbucket-hook');
        $vcs->save();
    }
}
