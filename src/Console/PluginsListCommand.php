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
namespace Codex\Console;

use Symfony\Component\Console\Input\InputOption;

class PluginsListCommand extends Command
{

    protected $signature = 'codex:plugins:list';

    protected $description = 'List all plugins';

    protected function configureUsingFluentDefinition()
    {
        parent::configureUsingFluentDefinition();
        $this->getDefinition()->addOption(new InputOption('detailed', 'd', InputOption::VALUE_NONE, 'Show detailed information'));
    }

    public function handle()
    {
        return $this->option('detailed') ? $this->listDetailed() : $this->list();
    }

    protected function list()
    {
        foreach ( codex()->addons->plugins->all() as $plugin ) {
            $this->line("- {$plugin->name}");
        }
    }


    public function listDetailed()
    {
        $table = collect();
        foreach ( codex()->addons->plugins->all() as $plugin ) {

            $table[] = [
                'Name'        => $plugin->name,
                'Description' => $plugin->description,
                'Requires'    => $plugin->requires ? implode(', ', $plugin->requires) : '-',
                'Replaces'    => $plugin->replace ? $plugin->replace : '-',
                'Enabled'     => codex()->addons->plugins->canRunPlugin($plugin) ? '<info>Yes</info>' : 'No',
            ];
        }

        $this->table(array_keys($table[ 0 ]), $table->map(function ($data) {
            return array_values($data);
        })->toArray());

    }
}
