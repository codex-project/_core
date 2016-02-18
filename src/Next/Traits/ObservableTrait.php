<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Traits;


/**
 * This is the class ObservableTrait.
 *
 * @package        Codex\Core
 * @author Sebwite
 * @copyright Copyright (c) 2015, Sebwite. All rights reserved
 *
 * @mixin EventTrait
 */
trait ObservableTrait
{

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

        foreach ( $instance->getObservableEvents() as $event ) {
            if ( method_exists($class, $event) ) {
                static::registerEventListener($event, $className . '@' . $event, $priority);
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

        foreach ( $instance->getObservableEvents() as $event ) {
            static::getDispatcher()->forget(static::getEventName($event) . get_called_class());
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
