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
namespace Codex\Addons\Presenters;


use ArrayAccess;
use Codex\Support\Traits\ArrayableAccess;
use Illuminate\Contracts\Support\Arrayable;
use Laradic\AnnotationScanner\Scanner\ClassFileInfo;

abstract class Presenter implements Arrayable, ArrayAccess
{
    use ArrayableAccess;

    /** @var ClassFileInfo */
    public $file;

    /** @var string */
    public $class;


    public function toArray()
    {
        $array = [];
        foreach(get_class_vars(get_class($this)) as $var => $val){
            $array[$var] = $this->{$var};
        }
        return $array;
    }

    public function hydrate(array $vars = [ ])
    {
        foreach(get_class_vars(get_class($this)) as $var => $val){
            if(array_key_exists($var, $vars)) {
                $this->{$var} = $vars[ $var ];
            }
        }
    }
}
