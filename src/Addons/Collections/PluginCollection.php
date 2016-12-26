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
namespace Codex\Addons\Collections;

use Codex\Addons\Annotations\Plugin;
use Codex\Addons\Hydrators\PluginHydrator;
use Codex\Exception\CodexException;
use Codex\Support\Sorter;
use Laradic\AnnotationScanner\Scanner\ClassFileInfo;

/**
 * This is the class Plugins.
 *
 * Plugin methods:
 * Register
 * Boot
 *
 * Plugin properties:
 * $project         = project config
 * $document        = document attributes
 * $views           = views (& overides)
 * $extend          = extensions
 * $routeExclusions = route exclusions
 *
 * @package        Codex\Addons
 * @author         Radic
 * @copyright      Copyright (c) 2015, Radic. All rights reserved
 *
 */
class PluginCollection extends BaseCollection
{
    public function add(ClassFileInfo $file, Plugin $annotation)
    {
        $class    = $file->getClassName();
        $instance = null; //$this->app->make($class);
        $data     = array_merge(compact('file', 'annotation', 'class', 'instance'), (array)$annotation);

        $presenter = $this->app->build(PluginHydrator::class);
        $presenter->hydrate($data);
        $this->set($annotation->name, $presenter);
        $a = 'a';
    }

    public function run()
    {
        // replace plugins, we sort out what plugin replaces which and do so.
        // filter plugins, we only want the ones enabled in the global codex config
        // sort plugins, if a plugin requires another plugin, it would get sorted as such.
        // ensure required plugins are installed and enabled, otherwise we throw an exception
        // with the resulting array of plugins, we will run each of them

        $replace = [];
        foreach ( $this->all() as $plugin ) {
            if ( $plugin->replace !== null ) {
                $replace[ $plugin->replace ] = $plugin->name;
            }
        }


        $plugins = $this->only(config('codex.plugins', []))->sorted();

        $plugins = $plugins->transform(function (PluginHydrator $plugin) use ($replace) {
            if ( array_key_exists($plugin->name, $replace) ) {
                return $this->get($replace[ $plugin->name ]);
            }
            return $plugin;
        });

        $plugins = $plugins->filter(function($plugin){
            return $this->canRunPlugin($plugin);
        });

        foreach ( $plugins as $plugin ) {
            $this->runPlugin($plugin);
        }
    }

    /**
     * canRunPlugin method
     *
     * @param string|PluginHydrator $plugin
     *
     * @return bool
     * @throws \Codex\Exception\CodexException
     */
    public function canRunPlugin($plugin)
    {
        if ( is_string($plugin) ) {
            // Check if exists
            if ( false === $this->has($plugin) ) {
                return false;
            }
            $plugin = $this->get($plugin);
        }
        // check global config if its enabled
        if ( false === in_array($plugin->name, config('codex.plugins', []), true) ) {
            return false;
        }

        // check if dependencies exists and are enabled
        foreach ( $plugin->requires as $name ) {
            if ( !$this->has($name) || !in_array($name, config('codex.plugins', []), true) ) {
                //throw CodexException::create("Plugin [{$plugin->name}] dependency [{$name}] does not exist or is not enabled");
                return false;
            }
        }
        return true;
    }

    protected function runPlugin(PluginHydrator $presenter)
    {
        $this->app->register($plugin = $presenter->getInstance());
    }

    /**
     * getSorted method
     *
     * @return PluginCollection
     * @throws \Codex\Exception\CodexException
     */
    public function sorted()
    {
        $sorter = new Sorter();
        foreach ( $this->all() as $plugin ) {
            $sorter->addItem($plugin->name, $plugin->requires);
        }

        return (new static($sorter->sort()))->transform(function ($name) {
            return $this->get($name);
        });
    }

    /**
     * get method
     *
     * @param mixed $name
     * @param null  $default
     *
     * @return PluginHydrator
     */
    public function get($name, $default = null)
    {
        return parent::get($name, $default);
    }

    /**
     * all method
     *
     * @return PluginHydrator[]
     */
    public function all()
    {
        return parent::all();
    }


}
