<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Traits;


use BadMethodCallException;
use Closure;
use Laradic\Support\Str;

trait ExtendableTrait
{
    use ContainerTrait;

    protected $_macros = [ ];

    protected $_extensions = [ ];

    protected $extensionInstances = [ ];

    public function extensions()
    {
        return array_merge(array_keys($this->getExtenableProperty('macros')), array_keys($this->getExtenableProperty('extensions')));
    }

    protected function getExtenableProperty($type)
    {
        $property = property_exists($this, $type) ? $type : "_{$type}";
        return $this->{$property};
    }

    public function extend($name, $extension)
    {
        if ( is_string($extension) && !Str::contains($extension, '@') ) {
            if ( array_key_exists($name, $this->getExtenableProperty('macros')) ) {
                throw new \InvalidArgumentException("Cannot extend [macro][{$name}] as [extension] because it already exists as [macro]. You can only replace [macro][{$name}] with an [macro]");
            }
            $this->getExtenableProperty('extensions')[ $name ] = $extension;
        } else {
            if ( array_key_exists($name, $this->getExtenableProperty('extensions')) ) {
                throw new \InvalidArgumentException("Cannot extend [extension][{$name}] as [macro] because it already exists as [extension]. You can only replace [extension][{$name}] with an [extension]");
            }
            $this->getExtenableProperty('macros')[ $name ] = $extension;
        }
    }

    /**
     * callExtension method
     *
     * @private
     *
     * @param $name
     * @param $parameters
     *
     * @return mixed
     */
    protected function callMacro($name, $parameters)
    {
        $callback = $this->getExtenableProperty('macros')[ $name ];

        if ( $callback instanceof Closure ) {
            return call_user_func_array($callback->bindTo($this, get_class($this)), $parameters);
        } elseif ( is_string($callback) && Str::contains($callback, '@') ) {
            return $this->callClassBasedMacro($callback, $parameters);
        }
    }


    /**
     * callClassBasedExtension method
     *
     * @private
     *
     * @param $callback
     * @param $parameters
     *
     * @return mixed
     */
    protected function callClassBasedMacro($callback, $parameters)
    {
        list($class, $method) = explode('@', $callback);
        $instance = $this->getContainer()->make($class, [
            'parent' => $this,
        ]);

        return call_user_func_array([ $instance, $method ], $parameters);
    }

    /**
     * getClassInstanceExtension method
     *
     * @param $name
     *
     * @private
     *
     * @return mixed
     */
    protected function getExtensionClassInstance($name)
    {
        $extension = $this->getExtenableProperty('extensions')[ $name ];

        if ( is_string($extension) && class_exists($extension) ) {
            if ( !array_key_exists($name, $this->extensionInstances) ) {
                $this->extensionInstances[ $name ] = $this->getContainer()->make($extension, [
                    'parent' => $this,
                ]);
            }

            return $this->extensionInstances[ $name ];
        }
    }

    public function __call($name, array $params = [ ])
    {
        if ( array_key_exists($name, $this->getExtenableProperty('macros')) ) {
            return $this->callMacro($name, $params);
        }
        throw new BadMethodCallException("Method [$name] does not exist.");
    }

    public function __get($name)
    {
        if ( array_key_exists($name, $this->getExtenableProperty('extensions')) ) {
            return $this->getExtensionClassInstance($name);
        }
    }

}
