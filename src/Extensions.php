<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core;

use Docit\Core\Contracts\Filter;
use Docit\Core\Contracts\Hook;

/**
 * This is the Extensions class.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class Extensions
{

    /**
     * @var array
     */
    protected static $hooks = [ ];

    /**
     * @var array
     */
    protected static $excludedProjectNames = [ ];

    /**
     * @var array
     */
    protected static $filters = [ ];


    # Hooks

    /**
     * Ensure point.
     *
     * @param  string $name
     * @return void
     */
    protected static function ensureHookPoint($name)
    {
        if (! isset(static::$hooks[ $name ])) {
            static::$hooks[ $name ] = [ ];
        }
    }

    /**
     * Register a hook instance.
     *
     * @param  string          $point
     * @param  string|\Closure $handler
     * @return void
     */
    public static function addHook($point, $handler)
    {
        if (! $handler instanceof \Closure and ! in_array(Hook::class, class_implements($handler), false)) {
            throw new \InvalidArgumentException("Failed adding hook. Provided handler for [{$point}] is not valid. Either provider a \\Closure or classpath that impelments \\Docit\\Docit\\Contracts\\Hook");
        }

        static::ensureHookPoint($point);
        static::$hooks[ $point ][] = $handler;
    }

    /**
     * Run the given hook.
     *
     * @param  string $name
     * @param  array  $params
     * @return void
     */
    public static function runHook($name, array $params = [ ])
    {
        static::ensureHookPoint($name);

        foreach (static::$hooks[ $name ] as $handler) {
            if ($handler instanceof \Closure) {

                call_user_func_array($handler, $params);
            } elseif (class_exists($handler)) {
                $instance = app()->make($handler);

                call_user_func_array([ $instance, 'handle' ], $params);
            }
        }
    }


    # Route projectName exclusions


    /**
     * get excludedProjectNames value
     *
     * @return array
     */
    public static function getExcludedProjectNames($parse = false)
    {
        return $parse === true ? implode('|', static::$excludedProjectNames) : static::$excludedProjectNames;
    }

    /**
     * addExcludedProjectNames
     *
     * @param string|array $projectNames
     */
    public static function addExcludedProjectNames($projectNames)
    {
        if (! is_array($projectNames)) {
            $projectNames = [ $projectNames ];
        }
        static::$excludedProjectNames = array_merge(static::$excludedProjectNames, $projectNames);
    }

    /**
     * Set the excludedProjectNames value
     *
     * @param array $excludedProjectNames
     * @return RouteServiceProvider
     */
    public static function setExcludedProjectNames(array $excludedProjectNames)
    {
        static::$excludedProjectNames = $excludedProjectNames;
    }


    # Filters


    /**
     * Add a new filter to the registered filters list.
     *
     * @param  string                                 $name
     * @param  \Closure|\Docit\Core\Contracts\Filter $handler
     * @return void
     */
    public static function filter($name, $handler)
    {
        if (! $handler instanceof \Closure and ! in_array(Filter::class, class_implements($handler), false)) {
            throw new \InvalidArgumentException("Failed adding Filter. Provided handler for [{$name}] is not valid. Must either provide a \\Closure or classpath that impelments \\Docit\\Docit\\Contracts\\Filter");
        }

        static::$filters[ $name ] = $handler;
    }

    /**
     * get filters value
     *
     * @return array
     */
    public static function getFilters($filterNames = null)
    {
        if (! is_null($filterNames)) {
            if (! is_array($filterNames)) {
                $filterNames = [ $filterNames ];
            }

            return array_only(static::$filters, $filterNames);
        } else {
            return static::$filters;
        }
    }
}
