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

if (!function_exists('version')) {
    /**
     * version method
     *
     * @param null $str
     * @param bool $loose
     *
     * @return \vierbergenlars\SemVer\version
     */
    function version($str = null, $loose = false)
    {
        return $str === null ? vierbergenlars\SemVer\version::class : new \vierbergenlars\SemVer\version($str, $loose);

    }
}

if (!function_exists('codex')) {
    /**
     * @param null $ext
     *
     * @return mixed|\Codex\Codex
     * @throws \Codex\Exception\CodexException
     */
    function codex($ext = null)
    {
        if(!app()->bound('codex') ) { //|| !app()->hasBeenBootstrapped()){
            throw \Codex\Exception\CodexException::create('Codex is not bound yet');
        }

        /** @var mixed $codex */
        $codex = app('codex');

        if($ext === null){
            return $codex;
        }

        return $codex->{$ext};
    }
}
