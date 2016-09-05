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

class ExtensionCollection extends BaseCollection
{
    public function add($class, $name, $extension)
    {
        $this->put($class . '::' . $name, $extension);
    }




}
