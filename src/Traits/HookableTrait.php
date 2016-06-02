<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Traits;


trait HookableTrait
{
    use EventTrait;

    public static function getEventName($event)
    {
        $namespace = static::getEventNamespace();
        $name      = last(explode('\\', get_class()));
        return "{$namespace}:{$event}";
    }

    public static function hook($event, $callback, $priority = 1)
    {
        static::registerEventListener($event, $callback, $priority);
    }

    protected function hookPoint($event, array $args = [ ], $halt = true)
    {
        return $this->fireEvent($event, $args, $halt);
    }

    protected function fireEvent($event, array $args = [ ], $halt = true)
    {
        $name = static::getEventName($event);
        return static::getDispatcher()->fire($name, array_merge([ $this ], $args), $halt);
    }


}
