<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Traits;


use BadMethodCallException;
use Closure;
use Sebwite\Support\Str;

trait ExtendableTrait
{
    use ContainerTrait;

    protected $extensions = [ ];

    protected $components = [ ];

    protected $componentInstances = [ ];

    public function extensions()
    {
        return array_keys($this->extensions);
    }

    public function extend($name, $extension)
    {
        if (is_string($extension) && !Str::contains($extension, '@')) {
            $this->components[ $name ] = $extension;
        } else {
            $this->extensions[ $name ] = $extension;
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
    protected function callExtension($name, $parameters)
    {
        $callback = $this->extensions[ $name ];

        if ($callback instanceof Closure) {
            return call_user_func_array($callback->bindTo($this, get_class($this)), $parameters);
        } elseif (is_string($callback) && Str::contains($callback, '@')) {
            return $this->callClassBasedExtension($callback, $parameters);
        }
    }


    /**
     * callClassBasedExtension method
     *
     * @private
     * @param $callback
     * @param $parameters
     *
     * @return mixed
     */
    protected function callClassBasedExtension($callback, $parameters)
    {
        list($class, $method) = explode('@', $callback);
        $instance = $this->getContainer()->make($class, [
            'parent' => $this
        ]);

        return call_user_func_array([ $instance, $method ], $parameters);
    }

    /**
     * getClassInstanceExtension method
     *
     * @param $name
     * @private
     *
     * @return mixed
     */
    protected function getClassInstanceExtension($name)
    {
        $extension = $this->components[ $name ];

        if (is_string($extension) && class_exists($extension)) {
            if (!array_key_exists($name, $this->componentInstances)) {
                $this->componentInstances[ $name ] = $this->getContainer()->make($extension, [
                    'parent' => $this
                ]);
            }

            return $this->componentInstances[ $name ];
        }
    }

    public function __call($name, array $params = [ ])
    {
        if (array_key_exists($name, $this->extensions)) {
            return $this->callExtension($name, $params);
        }
        throw new BadMethodCallException("Method [$name] does not exist.");
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->components)) {
            return $this->getClassInstanceExtension($name);
        }
    }

}
