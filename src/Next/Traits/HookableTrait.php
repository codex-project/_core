<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Traits;


trait HookableTrait
{
    use EventTrait;

    public static function getEventName($event)
    {
        $namespace = static::getEventNamespace();
        $name = last(explode('\\', get_class()));
        return "{$namespace}: {$name}.{$event}";
    }

    protected static function hook($event, $callback, $priority = 1)
    {
        static::registerEventListener($event, $callback, $priority);
    }

    protected function hookPoint($event, $halt = true)
    {
        return $this->fireEvent($event, $halt);
    }


}
