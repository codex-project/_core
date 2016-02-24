<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Contracts;


interface Extendable
{

    public function extensions();

    public function extend($name, $extension);

}
