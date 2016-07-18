<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Contracts\Traits;


interface Extendable
{

    public static function extensions();

    public static function extend($name, $extension);

}
