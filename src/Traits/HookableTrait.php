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

    /**
     * Returns the transformed (namespaced) event name for a hook
     *
     * @param string $event The hook name
     *
     * @return string The transformed event name
     */
    public static function getEventName($event)
    {
        $namespace = static::getEventNamespace();
        $name      = last(explode('\\', get_class()));
        return "{$namespace}:{$event}";
    }

    /**
     * Create a Codex Hook
     *
     * @param string $event The hook name
     * @param string|\Closure $callback The callback to execute
     * @param int $priority (optional) The priority
     */
    public static function hook($event, $callback, $priority = 1)
    {
        static::registerEventListener($event, $callback, $priority);
    }

    /**
     * Defines a point where hooks can hook
     *
     * @param string $event The hook name
     * @param array $args (optional) The arguments to pass along
     * @param bool  $halt (optional) If this hook can halt
     *
     * @return array|null
     */
    protected function hookPoint($event, array $args = [ ], $halt = true)
    {
        return $this->fireEvent($event, $args, $halt);
    }

    /**
     * Fires an event for hooks
     *
     * @param string $event The hook name
     * @param array $args (optional) The arguments to pass along
     * @param bool  $halt (optional) If this hook can halt
     *
     * @return array|null
     */
    protected function fireEvent($event, array $args = [ ], $halt = true)
    {
        $name = static::getEventName($event);
        return static::getDispatcher()->fire($name, array_merge([ $this ], $args), $halt);
    }


}
