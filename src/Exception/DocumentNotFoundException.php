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
namespace Codex\Exception;

class DocumentNotFoundException extends Exception
{
    public static function document($path)
    {
        return static::create("Could not find document [{$path}]");
    }

}
