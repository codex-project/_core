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
namespace Codex\Addons\Collections;

use Codex\Addons\Annotations\Hook;
use Codex\Addons\Scanner\ClassFileInfo;

class Hooks extends BaseCollection
{


    /**
     * add method
     *
     * @param \Codex\Addons\Scanner\ClassFileInfo      $file
     * @param                                          $annotation
     * @param string|null                              $method
     */
    public function add(ClassFileInfo $file, Hook $annotation, $method = null)
    {
        $class = $file->getClassName();

        $id       = $method === null ? $class : "{$class}@{$method}";
        $listener = $id;
        $this->set($id, array_merge(compact('file', 'annotation', 'class', 'listener'), (array)$annotation));

        if ( $annotation->replace ) {
            $this->set("{$annotation->replace}.replaced", $id);
        }

        $hooks = $this;
        $this->app->make('events')->listen('codex:' . $annotation->name, function () use ($hooks, $id) {
            if ( $hooks->has("{$id}.replaced") ) {
                return;
            }
            $listener = $hooks->get("{$id}.listener");
            $method = 'handle';
            if(str_contains($listener, '@')){
                list($class, $method) = explode('@', $listener);
            } else {
                $class = $listener;
            }
            $instance = $this->app->build($class);
            return call_user_func_array([ $instance, $method ], func_get_args());
        });
    }

    public function hook($name, $hook)
    {
        $this->app->make('events')->listen("codex:{$name}", $hook);
        return $this;
    }

}