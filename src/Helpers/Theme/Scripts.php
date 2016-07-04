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

/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 7/3/16
 * Time: 7:20 PM
 */

namespace Codex\Helpers\Theme;


class Scripts extends AbstractThemeHelper
{

    public function render()
    {
        $scripts = [ ];
        foreach ( $this->sorted() as $js )
        {
            $scripts[] = "<script>{$js['value']}</script>";
        }

        return implode("\n", $scripts);
    }

    public function add($name, $value, array $depends = [ ], array $attr = [ ])
    {
        $this->items->set($name, compact('name', 'value', 'depends', 'attr'));

        return $this;
    }

    public function sorted()
    {
        return $this->sorter($this->items);
    }
}
