<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core\Providers;

use Docit\Support\ConsoleServiceProvider as BaseConsoleServiceProvider;

/**
 * This is the ConsoleServiceProvider.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class ConsoleServiceProvider extends BaseConsoleServiceProvider
{
    protected $namespace = 'Docit\\Core\\Console';

    protected $prefix = 'docit.commands.';

    protected $commands = [
        'make' => 'Make',
        'list' => 'List'
    ];
}
