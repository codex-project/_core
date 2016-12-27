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
        'enabled' => [ 'attributes', 'parser', 'toc', 'header', 'phpdoc', 'macros' ],
        'toc'     => [
            'header_link_show' => true,
        ],
    ],

    'phpdoc' => [
        'enabled'       => true,
        'default_class' => 'Radic\\\BladeExtensions\\\BladeExtensionsServiceProvider',
    ],


    'git' => [
        'enabled'    => false, // disabled for testing with other files
        'owner'      => 'robinradic',
        'repository' => 'blade-extensions',
        'connection' => 'github',
        'sync'       => [
            'constraints' => [
                'branches'            => [ 'master' ],
                'versions'            => '>=6.0.0', //1.x || >=2.5.0 || 5.0.0 - 7.2.3'
                'skip_patch_versions' => true,
            ],
            'paths'       => [
                'docs'  => 'docs',
                'menu'  => 'docs/menu.yml',
                'index' => 'docs/index.md',
            ],
        ],
        'webhook'    => [
            'enabled' => true,
            'secret'  => env('CODEX_GIT_GITHUB_WEBHOOK_SECRET', ''),
        ],
    ],
];
