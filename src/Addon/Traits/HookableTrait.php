<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addon\Traits;


use Illuminate\Contracts\Events\Dispatcher;
use RuntimeException;
use Sebwite\Support\Str;

trait HookableTrait
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
        if ( !isset(static::$dispatcher) ) {

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

    public static function getEventNamespace()
    {
        $class = get_called_class();
        throw new RuntimeException("The Hookable class [{$class}] does not implement getEventNamespace method.");
    }

    /**
     * Register a model event with the dispatcher.
     *
     * @param  string          $event
     * @param  \Closure|string $callback
     * @param  int             $priority
     * @return void
     */
    protected static function listen($event, $callback, $priority = 0)
    {
        $name = get_called_class();

        $namespace = static::getEventNamespace();

        static::getDispatcher()->listen("{$namespace}.{$event}: {$name}", $callback, $priority);
    }

    /**
     * Fire the given event for the model.
     *
     * @param  string $event
     * @param  bool   $halt
     * @return mixed
     */
    protected function emit($event, $halt = true)
    {
        $namespace = static::getEventNamespace();

        // We will append the names of the class to the event to distinguish it from
        // other model events that are fired, allowing us to listen on each model
        // event set individually instead of catching event for all the models.
        $event = "{$namespace}.{$event}: " . get_class($this);

        $method = $halt ? 'until' : 'fire';

        return static::getDispatcher()->$method($event, $this);
    }

    /**
     * Register an observer with the Model.
     *
     * @param  object|string $class
     * @param  int           $priority
     * @return void
     */
    public static function observe($class, $priority = 0)
    {
        $instance = new static;

        $className = is_string($class) ? $class : get_class($class);

        // When registering a model observer, we will spin through the possible events
        // and determine if this observer has that method. If it does, we will hook
        // it into the model's event system, making it convenient to watch these.
        foreach ( $instance->getObservableEvents() as $event ) {
            if ( method_exists($class, $event) ) {
                static::listen($event, $className . '@' . $event, $priority);
            }
        }
    }

    /**
     * Remove all of the event listeners for the model.
     *
     * @return void
     */
    public function flushEventListeners()
    {
        $instance = new static;
        $namespace = Str::ensureRight('.', $this->getEventNamespace());

        foreach ( $instance->getObservableEvents() as $event ) {
            static::getDispatcher()->forget("{$namespace}: {$event}" . get_called_class());
        }
    }

    /**
     * Get the observable event names.
     *
     * @return array
     */
    public function getObservableEvents()
    {
        return property_exists($this, 'observables') ? $this->observables : [ ];
    }

    /**
     * Set the observable event names.
     *
     * @param  array $observables
     * @return $this
     */
    public function setObservableEvents(array $observables)
    {
        if ( !property_exists($this, 'observables') ) {
            $class = get_class($this);
            throw new \LogicException("The class {$class} should have the property [observables]");
        }

        $this->observables = $observables;

        return $this;
    }

    /**
     * Add an observable event name.
     *
     * @param  array|mixed $observables
     * @return void
     */
    public function addObservableEvents($observables)
    {
        $observables = is_array($observables) ? $observables : func_get_args();

        $this->setObservableEvents(array_unique(array_merge($this->getObservableEvents(), $observables)));
    }

    /**
     * Remove an observable event name.
     *
     * @param  array|mixed $observables
     * @return void
     */
    public function removeObservableEvents($observables)
    {
        $observables = is_array($observables) ? $observables : func_get_args();

        $this->setObservableEvents(array_diff($this->getObservableEvents(), $observables));
    }


}
