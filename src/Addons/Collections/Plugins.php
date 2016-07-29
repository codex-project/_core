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

use Codex\Addons\Annotations\Plugin;
use Codex\Addons\Scanner\ClassFileInfo;

class Plugins extends BaseCollection
{
    public function add(ClassFileInfo $file, Plugin $annotation){
        $class = $file->getClassName();
        $instance = null; //$this->app->make($class);
        $data     = array_merge(compact('file', 'annotation', 'class', 'instance'), (array)$annotation);
        $this->set($annotation->name, $data);

        $a = 'a';
    }

}
