<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Providers;

use Sebwite\Support\ConsoleServiceProvider as BaseConsoleServiceProvider;

/**
 * This is the ConsoleServiceProvider.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class ConsoleServiceProvider extends BaseConsoleServiceProvider
{
    protected $namespace = 'Codex\\Core\\Commands';

    protected $prefix = 'codex.commands.';

    protected $commands = [
        'make' => 'Make',
        'list' => 'List'
    ];
}
