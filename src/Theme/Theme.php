<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Theme;


use Sebwite\Support\Traits\DotArrayObjectTrait;
use Sebwite\Support\Traits\DotArrayTrait;

/**
 * This is the class Theme.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @property string $layout
 * @property string $view
 *
 */
class Theme
{

    use DotArrayTrait, DotArrayObjectTrait;

    protected $attributes;


    /**
     * Get array accessor.
     *
     * @return mixed
     */
    protected function getArrayAccessor()
    {
        return 'attributes';
    }

    public function asset($key)
    {
        return '';
    }
}
