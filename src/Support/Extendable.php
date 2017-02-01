<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Support;

use Codex\Contracts;

abstract class Extendable implements
    Contracts\Traits\Extendable,
    Contracts\Traits\Bootable,
    Contracts\Traits\Hookable,
    Contracts\Traits\Observable
{
    use Traits\HookableTrait,   #Traits\EventTrait,
        Traits\ObservableTrait,
        Traits\BootableTrait,
        Traits\ExtendableTrait, #Traits\ContainerTrait
        Traits\Builder,
        Traits\CodexTrait;
}
