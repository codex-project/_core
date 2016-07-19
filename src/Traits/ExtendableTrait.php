<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Traits;


use BadMethodCallException;
use Closure;
use Sebwite\Support\Str;

trait ExtendableTrait
{
    use ContainerTrait;

    static protected $_macros = [ ];

    static protected $_extensions = [
        // called class => [ name => class ]
    ];

    protected $extensionInstances = [ ];

    /**
     * Returns all registered extensions for this class
     * @return array The registered extensions for this class
     */
    public static function extensions()
    {
        return array_merge(array_keys(static::getExtenableProperty('macros')), array_keys(static::getExtenableProperty('extensions')));
    }

    /**
     * This will return the property. It checks if the property name exists and will return it. If it doesn't exist, it will return the property prefixed with _ (underscore)
     *
     * @param string $type The property name
     *
     * @return mixed
     */
    public static function &getExtenableProperty($type)
    {
        $property = property_exists(static::class, $type) ? $type : "_{$type}";
        $props =& static::$$property;
        $class = get_called_class();
        if(!array_key_exists($class, $props)){
            $props[$class] = [];

        }
        return $props[$class];
    }

    /**
     * Extend the class with a class or method.
     *
     * @param string          $name      The name to register the extension under
     * @param string|\Closure $extension The extension that should be used
     */
    public static function extend($name, $extension)
    {
        if ( is_string($extension) && !Str::contains($extension, '@') ) {
            if ( array_key_exists($name, static::getExtenableProperty('macros')) ) {
                throw new \InvalidArgumentException("Cannot extend [macro][{$name}] as [extension] because it already exists as [macro]. You can only replace [macro][{$name}] with an [macro]");
            }
            static::getExtenableProperty('extensions')[ $name ] = $extension;
        } else {
            if ( array_key_exists($name, static::getExtenableProperty('extensions')) ) {
                throw new \InvalidArgumentException("Cannot extend [extension][{$name}] as [macro] because it already exists as [extension]. You can only replace [extension][{$name}] with an [extension]");
            }
            static::getExtenableProperty('macros')[ $name ] = $extension;
        }
    }

    /**
     * Calls a macro extension (method) with the given parameters
     *
     * @internal
     *
     * @param string $name       The name of the macro
     * @param array  $parameters The optional parameters
     *
     * @return mixed
     */
    protected function callMacro($name, $parameters = [ ])
    {
        $callback = static::getExtenableProperty('macros')[ $name ];

        if ( $callback instanceof Closure ) {
            return call_user_func_array($callback->bindTo($this, get_class($this)), $parameters);
        } elseif ( is_string($callback) && Str::contains($callback, '@') ) {
            return $this->callClassBasedMacro($callback, $parameters);
        }
    }


    /**
     * Calls a macro extension that has been defined with a `Class[at]method` notation. This enabled dependency injection in the constructor of the extension.
     *
     * @internal
     *
     * @param string $callback   The fqn class method string to call
     * @param array  $parameters The optional parameters
     *
     * @return mixed
     */
    protected function callClassBasedMacro($callback, $parameters = [ ])
    {
        list($class, $method) = explode('@', $callback);
        $instance = $this->getContainer()->make($class, [
            'parent' => $this,
        ]);

        return call_user_func_array([ $instance, $method ], $parameters);
    }

    /**
     * This will return the instance of a class extension or otherwise instanciate it. It will only instantiate once then keeps it in memory.
     *
     * @param string $name The name of the extension
     *
     * @internal
     *
     * @return mixed
     */
    protected function getExtensionClassInstance($name)
    {
        $extension = static::getExtenableProperty('extensions')[ $name ];

        if ( is_string($extension) && class_exists($extension) ) {
            if ( !array_key_exists($name, $this->extensionInstances) ) {
                $this->extensionInstances[ $name ] = $this->getContainer()->make($extension, [
                    'parent' => $this,
                ]);
            }

            return $this->extensionInstances[ $name ];
        }
    }

    /**
     * Allows macro extensions to be called
     *
     * @param string $name   The name of the extension
     * @param array  $params The optional parameters
     *
     * @return mixed
     */
    public function __call($name, array $params = [ ])
    {
        if ( array_key_exists($name, static::getExtenableProperty('macros')) ) {
            return $this->callMacro($name, $params);
        }
        throw new BadMethodCallException("Method [$name] does not exist.");
    }

    /**
     * Allows class extensions to return it's value.
     *
     * @param string $name The name of the extension
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ( array_key_exists($name, static::getExtenableProperty('extensions')) ) {
            return $this->getExtensionClassInstance($name);
        }
    }

}
