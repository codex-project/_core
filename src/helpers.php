<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


if(!function_exists('version')){
    /**
     * version method
     *
     * @param null $str
     * @param bool $loose
     *
     * @return \vierbergenlars\SemVer\version
     */
    function version($str = null, $loose = false){
        return $str === null ? vierbergenlars\SemVer\version::class : new \vierbergenlars\SemVer\version($str, $loose);

    }
}