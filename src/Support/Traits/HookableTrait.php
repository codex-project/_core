<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */


namespace Codex\Support\Traits;


use Codex\Exception\CodexException;
use Laradic\Support\Arr;

trait HookableTrait
{
    use EventTrait;

    public static $hookPoints = [ ];

    public static $hooks = [ ];

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
     * Defines a point where hooks can hook
     *
     * @param string $event The hook name
     * @param array  $args  (optional) The arguments to pass along
     * @param bool   $halt  (optional) If this hook can halt
     *
     * @return array|null
     */
    protected function hookPoint($event, array $args = [ ], $halt = true)
    {
        if ( config('codex.dev.enabled', false) === true )
        {
            if ( array_key_exists($event, static::$hookPoints) )
            {
                throw CodexException::because('hook point already exists');
            }
            Arr::add(static::$hooks, $event, static::getDispatcher()->getListeners($event));
            $caller = $this->hookPointGetCaller(debug_backtrace(), 1);
            $caller = array_only($caller, [ 'function', 'class' ]);
            Arr::set(static::$hookPoints, static::getEventName($event), $caller);
        }
        return $this->fireEvent($event, $args, $halt);
    }

    protected function hookPointGetCaller(array $trace, $current, $max = 5)
    {
        if ( $current + 1 > $max )
        {
            return null;
        }
        if ( isset($trace[ $current ]) )
        {
            if ( $trace[ $current ][ 'function' ] === 'hookPoint' )
            {
                return $this->hookPointGetCaller($trace, $current + 1);
            }
            else
            {
                return $trace[ $current ];
            }
        }
    }

    /**
     * Fires an event for hooks
     *
     * @param string $event The hook name
     * @param array  $args  (optional) The arguments to pass along
     * @param bool   $halt  (optional) If this hook can halt
     *
     * @return array|null
     */
    protected function fireEvent($event, array $args = [ ], $halt = true)
    {
        $name = static::getEventName($event);
        return static::getDispatcher()->fire($name, array_merge([ $this ], $args), $halt);
    }


}
