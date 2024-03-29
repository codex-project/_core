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

use Illuminate\Contracts\Events\Dispatcher;

trait EventTrait
{

    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Events\Dispatcher
     */
    protected static $dispatcher;

    /**
     * Returns the event dispatcher.
     *
     * @return \Illuminate\Events\Dispatcher
     */
    public static function getDispatcher()
    {
        if (!isset(static::$dispatcher)) {
            static::$dispatcher = function_exists('app') ?
                app(Dispatcher::class) :
                forward_static_call_array('Illuminate\Container\Container::make', [ Dispatcher::class ]);
        }
        return static::$dispatcher;
    }


    /**
     * Sets the event dispatcher instance.
     *
     * @param  \Illuminate\Events\Dispatcher $dispatcher
     *
     * @return $this
     */
    public static function setDispatcher(Dispatcher $dispatcher)
    {
        static::$dispatcher = $dispatcher;
    }

    /**
     * Unset the event dispatcher for models.
     *
     * @return void
     */
    public static function unsetEventDispatcher()
    {
        static::$dispatcher = null;
    }

    /**
     * getEventNamespace method
     * @throw RuntimeException
     * @return string
     */
    public static function getEventNamespace()
    {
        return 'codex';
    }

    /**
     * Register a model event with the dispatcher.
     *
     * @param  string          $event
     * @param  \Closure|string $callback
     * @param  int             $priority
     *
     * @return void
     */
    protected static function registerEventListener($event, $callback, $priority = 0)
    {
        static::getDispatcher()->listen(static::getEventName($event), $callback, $priority);
    }

    protected static function getEventName($event)
    {
        return static::getEventNamespace() . '.' . $event;
    }

    /**
     * fireEvent method
     *
     * @param       $event
     * @param array $args
     * @param bool  $halt
     *
     * @return mixed
     */
    protected function fireEvent($event, array $args = [ ], $halt = true)
    {
        $method = $halt ? 'until' : 'fire';
        $name   = static::getEventName($event);
        return static::getDispatcher()->$method($name, $args);
    }
}
