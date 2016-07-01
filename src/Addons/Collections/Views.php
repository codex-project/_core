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
namespace Codex\Addons\Collections;

class Views extends BaseCollection
{
    public function __construct(array $items, $addons)
    {
        parent::__construct([

            'layouts'    => [
                'base'    => 'codex::layouts.base',
                'default' => 'codex::layouts.default',
            ],
            'layout'     => 'codex::layouts.default',
            'document'   => 'codex::document',
            'error'      => 'codex::error',
            'menus'      => [
                'sidebar'  => 'codex::menus.sidebar',
                'projects' => 'codex::menus.header-dropdown',
                'versions' => 'codex::menus.header-dropdown',
            ],
            'processors' => [
                'header'  => 'codex::processors.header',
                'toc'     => 'codex::processors.toc',
                'buttons' => 'codex::processors.buttons',
            ],
        ], $addons);
    }

}