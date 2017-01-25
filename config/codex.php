<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */

// Documentation: http://codex-project.dev/codex/master/getting-started/configuration/global
return [
    'display_name' => env('CODEX_DISPLAY_NAME', 'Codex (BETA)'),

    'description' => 'Codex is a file-based documentation platform built on top of Laravel. It\'s completely customizable and dead simple to use to create beautiful documentation.',

    'default_project' => env('CODEX_DEFAULT_PROJECT', 'codex'),

    'plugins' => [ 'phpdoc', 'auth', 'git', 'jira', 'welcome' ],

    'paths' => [
        'docs'     => env('CODEX_ROOT_DIR', base_path('resources/docs')),
        'stubs'    => __DIR__ . '/../resources/stubs',
        'manifest' => storage_path('codex.json'),
        'log'      => storage_path('logs/codex.log'),
    ],

    'http' => [
        // you can disable the http service if you want to use your own, or some other reason
        'enabled'         => true,
        // run codex under a specific uri. For example, setting this to 'foobar' will result in urls like
        // http://host.com/foobar/documentation/$PROJECT/$REF/$DOCUMENT
        // http://host.com/foobar/api/v1
        // you can leave this to null to not have a base_route
        'base_route'      => env('CODEX_BASE_ROUTE', null),
        'document_prefix' => 'documentation',

        'route_prefix'          => null,
        'document_route_prefix' => 'documentation',

        'ignore_project_names' => [ '_debugbar', ],
        'api'                  => [
            'enabled'    => true,
            'middleware' => [],
            'tokens'     => [],
        ],
    ],

    'log' => true,

    // Enables the codex development helpers. Note that this also requires app.debug to be true
    'dev' => env('CODEX_DEV_ENABLED', true),

    'document'   => [
        'cache'      => [
            // true     = enabled
            // false    = disabled
            // null     = disabled when app.debug is true
            'mode'    => null,


            // Whenever a document's last modified time changes, the document's cache is refreshed.
            // It is possible to set this to null making it refresh by checking last modified.
            // Alternatively, you can also set a max duration in minutes.
            // Recommended is to put it on null
            'minutes' => 7,
        ],
        'extensions' => [
            'md'       => 'codex.document',
            'markdown' => 'codex.document',
            'html'     => 'codex.document',
            'rst'      => 'codex.document',
        ],
    ],



    'default_project_config' => [
        'description' => '',
        'default'     => \Codex\Projects\Refs::DEFAULT_AUTO,
        'custom'      => null,
        'first'       => '',
        'index'       => 'index',
        'extensions'  => [ 'md', 'markdown', 'html' ],
        'processors'  => [
            'enabled' => [],
        ],
    ],

    'default_document_attributes' => [
        'author'     => 'John Doe',
        'title'      => '',
        'subtitle'   => '',
        'view'       => null,
        'cache'      => true,
        'processors' => [
            'enabled'  => [],
            'disabled' => [],
        ],
    ],

];
