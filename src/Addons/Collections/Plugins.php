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
use Codex\Addons\Presenters\PluginPresenter;
use Codex\Exception\CodexException;
use Codex\Support\Sorter;
use Illuminate\Config\Repository;
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
class Plugins extends BaseCollection
{
    public function add(ClassFileInfo $file, Plugin $annotation)
    {
        $class    = $file->getClassName();
        $instance = null; //$this->app->make($class);
        $data     = array_merge(compact('file', 'annotation', 'class', 'instance'), (array)$annotation);

        $presenter = $this->app->build(PluginPresenter::class);
        $presenter->hydrate($data);
        $this->set($annotation->name, $presenter);
        $a = 'a';
    }

    public function run()
    {
        foreach($this->getSorted() as $plugin){
            $this->app->booted(function($app) use ($plugin) {
                $plugin->instance->booted();
            });
        }
    }

    /**
     * getSorted method
     *
     * @return \Codex\Addons\Presenters\PluginPresenter[]
     * @throws \Codex\Exception\CodexException
     */
    public function getSorted()
    {
        $sorter = new Sorter();
        foreach(config('codex.plugins', []) as $name){
            /** @var PluginPresenter $plugin */
            $plugin = $this->get($name);
            if($plugin === null){
                throw CodexException::because('[Plugin Not Found] ' . $name);
            }
            $sorter->add($plugin->name, $plugin->requires);
        }
        return $sorter->sort();
    }

    public function get($name, $default = null)
    {
        return parent::get($name, $default);
    }

}
