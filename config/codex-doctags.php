<?php
/**
 * Part of the CLI PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */

return [
    'tags' => [
        [
            'name' => 'table',
            'function' => ''
        ]
    ],
    'tag' => [
        '/table:responsive\((.*)\)/' => \Codex\Addons\Filters\DocTags\Table::class . '@tableResponsive'
    ]
];