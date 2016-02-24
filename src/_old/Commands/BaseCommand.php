<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Commands;

use Codex\Core\Contracts\Codex;
use Sebwite\Support\Console\Command;
use Sebwite\Support\StubGenerator;

/**
 * This is the CodexMakeCommand.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
abstract class BaseCommand extends Command
{
    /**
     * @var \Codex\Core\Factory
     */
    protected $codex;

    protected $generator;

    public function __construct(Codex $factory, StubGenerator $generator)
    {
        parent::__construct();
        $this->codex     = $factory;
        $this->generator = $generator;
    }

    #
    # GENERATOR

    /**
     * generate
     *
     * @param array $files
     * @param array $vars
     */
    public function generate($directory, array $files = [ ], array $vars = [ ])
    {
        $this->generator->generate(
            $this->codex->config('stubs_path'),
            $this->codex->getRootDir() . DIRECTORY_SEPARATOR . $directory,
            $files,
            array_replace_recursive($this->getGeneratorVars($directory), $vars)
        );
    }

    /**
     * getVars
     *
     * @param null $packageName
     * @return array
     */
    public function getGeneratorVars($directory)
    {
        $stubDir = $this->codex->config('stubs_path');
        $destDir = $this->codex->getRootDir() . DIRECTORY_SEPARATOR . $directory;

        $vars = [
            'config'    => array_dot($this->codex->config()),
            'open'      => '<?php',
            'stubDir'   => $stubDir,
            'destDir'   => $destDir,
            'directory' => $directory
        ];

        return $vars;
    }
}
