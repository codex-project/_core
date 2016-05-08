<?php
namespace Codex\Core\Addons\Filters;

use Codex\Core\Addons\Annotations\Theme;

/**
 * This is the class DefaultTheme.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @Theme("default")
 */
class DefaultTheme
{

    public function views()
    {
        return [
            'layout'   => 'codex::layouts.default',
            'document' => 'codex::document',
            'menus'    => [
                'sidebar'  => 'codex::menus.sidebar',
                'projects' => 'codex::menus.projects',
                'versions' => 'codex::menus.versions',
            ],
        ];
    }
}