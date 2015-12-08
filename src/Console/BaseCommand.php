<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core\Console;

use Docit\Support\Command;
use Docit\Core\Contracts\Factory;

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
    protected $factory;

    public function __construct(Factory $factory)
    {
        parent::__construct();
        $this->factory = $factory;
    }
}
