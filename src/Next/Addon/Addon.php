<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Addon;

use Codex\Core\Next\Contracts\Bootable;
use Codex\Core\Next\Contracts\Extendable;
use Codex\Core\Next\Contracts\Hookable;
use Codex\Core\Next\Contracts\Observable;
use Codex\Core\Next\Traits;

abstract class Addon implements
    Extendable,
    Hookable,
    Observable,
    Bootable
{
    use Traits\ExtendableTrait,
        Traits\HookableTrait,
        Traits\ObservableTrait,
        Traits\BootableTrait;


}
