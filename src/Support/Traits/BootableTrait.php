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


use Codex\Contracts\Traits\Bootable;
use Codex\Contracts\Traits\Hookable;
use Codex\Exception\CodexException;

/**
 * The BootableTrait works similar to Eloquent Models. The traits that are added can include a bootTraitName function which will be called on initialisation of the object. Requires the EventTrait to be present aswell.
 *
 * @package        Codex\Traits
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 * @see \Codex\Traits\EventTrait The required EventTrait
 */
trait BootableTrait
{

    protected static $booted = [ ];

    /**
     * Check if the model needs to be booted and if so, do it.
     *
     * @throws \Codex\Exception\ContractMissingException
     */
    protected function bootIfNotBooted()
    {
        $class = get_class($this);

        if ( !class_implements($class, Hookable::class) ) {
            throw CodexException::implementationMismatch(Hookable::class);
        }
        if ( !class_implements($class, Bootable::class) ) {
            throw CodexException::implementationMismatch(Bootable::class);
        }

        if ( !isset(static::$booted[ $class ]) ) {
            static::$booted[ $class ] = true;

            $this->fireEvent('booting', false);

            static::boot();

            $this->fireEvent('booted', false);
        }
    }

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::bootTraits();
    }

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected static function bootTraits()
    {
        foreach ( class_uses_recursive(get_called_class()) as $trait ) {
            if ( method_exists(get_called_class(), $method = 'boot' . class_basename($trait)) ) {
                forward_static_call([ get_called_class(), $method ]);
            }
        }
    }

    /**
     * Clear the list of booted models so they will be re-booted.
     *
     * @return void
     */
    public static function clearBooted()
    {
        static::$booted = [ ];
    }

    /**
     * The wakeup magic method is used to boot the bootable stuff
     * @throws \Codex\Exception\ContractMissingException
     */
    public function __wakeup()
    {
        $this->bootIfNotBooted();
    }

    /**
     * Register a listener for the "booting" event of this class
     *
     * @param string|\Closure $callback
     *
     * @return string The class name
     */
    public static function booting($callback)
    {
        static::registerEventListener('booting', $callback);

        return static::class;
    }

    /**
     * Register a listener for the "booted" event of this class
     *
     * @param string|\Closure $callback
     *
     * @return string The class name
     */
    public static function booted($callback)
    {
        static::registerEventListener('booted', $callback);

        return static::class;
    }
}
