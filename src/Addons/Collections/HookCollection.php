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

use Closure;
use Codex\Addons\Annotations\Hook;
use Doctrine\Common\Annotations\AnnotationReader;
use Laradic\AnnotationScanner\Scanner\ClassFileInfo;
use Laradic\AnnotationScanner\Scanner\ClassInspector;
use Symfony\Component\Finder\SplFileInfo;

class HookCollection extends BaseCollection
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

        if ( $method instanceof Closure )
        {
            $id       = $class . '@' . str_random();
            $listener = $method;
        }
        else
        {
            $id       = $method === null ? $class : "{$class}@{$method}";
            $listener = $id;
        }

        $this->set($id, array_merge(compact('file', 'annotation', 'class', 'listener'), (array)$annotation));

        if ( $annotation->replace )
        {
            $this->set("{$annotation->replace}.replaced", $id);
        }

        $hooks = $this;
        $this->app->make('events')->listen('codex:' . $annotation->name, function () use ($hooks, $id)
        {
            if ( $this->has("{$id}.replaced") )
            {
                return;
            }
            $listener = $this->get("{$id}.listener");
            if ( $listener instanceof Closure )
            {
                return call_user_func_array($listener, func_get_args());
            }
            $method = 'handle';
            if ( str_contains($listener, '@') )
            {
                list($class, $method) = explode('@', $listener);
            }
            else
            {
                $class = $listener;
            }
            $instance = $this->app->build($class);
            return call_user_func_array([ $instance, $method ], func_get_args());
        });
    }

    public function hook($name, $hook, $replace = false)
    {
        $annotation          = new Hook();
        $annotation->name    = $name;
        $annotation->replace = $replace;
        $file                = debug_backtrace()[ 1 ][ 'file' ];
        $class               = debug_backtrace()[ 1 ][ 'class' ];
        $fileInfo            = new SplFileInfo($file, $file, $file);
        $classFileInfo       = new ClassFileInfo($fileInfo, new ClassInspector($class, new AnnotationReader()));
        $this->add($classFileInfo, $annotation, $hook);
        //$this->app->make('events')->listen("codex:{$name}", $annotation);
        return $this;
    }

}
