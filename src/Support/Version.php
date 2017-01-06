<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Support;

use vierbergenlars\SemVer\SemVerException;

class Version extends \vierbergenlars\SemVer\version
{
    /**
     * create method
     *
     * @param      $string
     * @param bool $loose
     *
     * @return bool|static
     */
    public static function create($string, $loose = false)
    {
        try {
            return new static($string, $loose);
        } catch (SemVerException $e){
            return false;
        }
    }

    /**
     * isValid method
     *
     * @param $string
     *
     * @return bool
     */
    public static function isValid($string)
    {
        return static::create($string) !== false;
    }
}


