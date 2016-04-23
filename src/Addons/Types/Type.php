<?php
/**
 * Part of the CLI PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */

namespace Codex\Core\Addons\Types;


interface Type
{
    const DOCUMENT = 'document';
    const HOOK = 'hook';
    const FILTER = 'filter';
    const THEME = 'theme';
    const CONFIG = 'config';

    public function getType();

    public function getName();

    public function getClass();
}