<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addons;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }


    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param  string $path
     * @param  string $key
     *
     * @return void
     */
    public static function _mergeConfigFrom($path, $key)
    {
        $config = app('config')->get($key, [ ]);

        app('config')->set($key, array_merge(require $path, $config));
    }

    /**
     * Register a view file namespace.
     *
     * @param  string $path
     * @param  string $namespace
     *
     * @return void
     */
    public static function _loadViewsFrom($path, $namespace)
    {
        if ( is_dir($appPath = app()->basePath() . '/resources/views/vendor/' . $namespace) )
        {
            app('view')->addNamespace($namespace, $appPath);
        }

        app('view')->addNamespace($namespace, $path);
    }

    /**
     * Register a translation file namespace.
     *
     * @param  string $path
     * @param  string $namespace
     *
     * @return void
     */
    public static function _loadTranslationsFrom($path, $namespace)
    {
        app('translator')->addNamespace($namespace, $path);
    }


    public static function _publishes(array $paths, $group = null)
    {
        $class = static::class;

        if ( ! array_key_exists($class, static::$publishes) )
        {
            static::$publishes[ $class ] = [ ];
        }

        static::$publishes[ $class ] = array_merge(static::$publishes[ $class ], $paths);

        if ( $group )
        {
            if ( ! array_key_exists($group, static::$publishGroups) )
            {
                static::$publishGroups[ $group ] = [ ];
            }

            static::$publishGroups[ $group ] = array_merge(static::$publishGroups[ $group ], $paths);
        }
    }

    public static function getPublishes()
    {
        return static::$publishes;
    }

    public static function getPublishGroups()
    {
        return static::$publishGroups;
    }


    /**
     * Get the paths to publish.
     *
     * @param  string $provider
     * @param  string $group
     *
     * @return array
     */
    public static function _pathsToPublish($provider = null, $group = null)
    {
        if ( $provider && $group )
        {
            if ( empty(static::$publishes[ $provider ]) || empty(static::$publishGroups[ $group ]) )
            {
                return [ ];
            }

            return array_intersect_key(static::$publishes[ $provider ], static::$publishGroups[ $group ]);
        }

        if ( $group && array_key_exists($group, static::$publishGroups) )
        {
            return static::$publishGroups[ $group ];
        }

        if ( $provider && array_key_exists($provider, static::$publishes) )
        {
            return static::$publishes[ $provider ];
        }

        if ( $group || $provider )
        {
            return [ ];
        }

        $paths = [ ];

        foreach ( static::$publishes as $class => $publish )
        {
            $paths = array_merge($paths, $publish);
        }

        return $paths;
    }
}