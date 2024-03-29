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
return [
    'display_name' => 'Blade Extensions',

    'processors' => [
        'enabled' => [ 'attributes', 'parser', 'toc', 'header', 'macros' ],
        'toc'     => [
            'header_link_show' => true,
        ],
    ],
];
