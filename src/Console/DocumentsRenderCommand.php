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

use Laradic\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class DocumentsRenderCommand extends Command
{

    protected $signature = 'codex:documents:render {query}';

    protected $description = 'List all plugins';

    public function handle()
    {
        $document = codex()->get($this->argument('query'))->render();
        if ($this->option('file')) {
            $path = $this->option('file');
            $path = path_normalize(path_is_relative($path) ? path_join(getcwd(), $path) : $path);

            if (file_exists($path) && $this->confirm("File already exists at [{$path}]. Overide?", false) === false) {
                return $this->error('Operation aborted');
            }
            if (file_isDirectory($dir = path_get_directory($path)) === false) {
                return $this->error("The destination directory does not exist [{$dir}]");
            }
            file_put($path, $document);
            return $this->info("Document has been written to [{$path}]");
        }
        $this->line($document);
    }

    protected function configure()
    {
        parent::configure();
        $this->getDefinition()->addOption(
            new InputOption('file', 'f', InputOption::VALUE_OPTIONAL, 'Redirect the output to write into a file at the given path')
        );
    }
}
