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

class ViewCollection extends BaseCollection
{
    public function __construct(array $items, $addons)
    {
        parent::__construct([
            'menus'      => [
                'sidebar' => 'codex::menus.sidebar',
                'header'  => 'codex::menus.header',
            ],
            'processors' => [
                'header'  => 'codex::processors.header',
                'toc'     => 'codex::processors.toc',
                'buttons' => 'codex::processors.buttons',
            ],
            'layout'     => 'codex::layout',
            'welcome'    => 'codex::welcome',
            'document'   => 'codex::document',
            'error'      => 'codex::error',
        ], $addons);
    }

    public function merge($items)
    {
        foreach ( array_dot($items) as $key => $value ) {
            $this->set($key, $value);
        }
        return $this;
    }


}
