<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core\Console;

use Docit\Core\Contracts\Factory;
use Docit\Support\Command;
use Docit\Support\StubGenerator;

/**
 * This is the DocitMakeCommand.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
abstract class BaseCommand extends Command
{
    /**
     * @var \Docit\Core\Factory
     */
    protected $docit;

    protected $generator;

    public function __construct(Factory $factory, StubGenerator $generator)
    {
        parent::__construct();
        $this->docit     = $factory;
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
            $this->docit->config('stubs_path'),
            $this->docit->getRootDir() . DIRECTORY_SEPARATOR . $directory,
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
        $stubDir = $this->docit->config('stubs_path');
        $destDir = $this->docit->getRootDir() . DIRECTORY_SEPARATOR . $directory;

        $vars = [
            'config'    => array_dot($this->docit->config()),
            'open'      => '<?php',
            'stubDir'   => $stubDir,
            'destDir'   => $destDir,
            'directory' => $directory
        ];

        return $vars;
    }
}
