<?php
namespace Codex\Support;

use Codex\Contracts;
use Codex\Traits;

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
        Traits\CodexTrait;
}
