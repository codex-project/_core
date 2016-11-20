<?php

// Documentation: http://codex-project.dev/codex/master/getting-started/configuration/global
return [


    'display_name' => env('CODEX_DISPLAY_NAME', 'Codex (BETA)'),

    'theme' => null,

    'default_project' => env('CODEX_DEFAULT_PROJECT', 'codex'),

    'paths' => [
        'docs'     => env('CODEX_ROOT_DIR', base_path('resources/docs')),
        'stubs'    => __DIR__ . '/../resources/stubs',
        'manifest' => storage_path('codex.json'),
        'log'      => storage_path('logs/codex.log'),
    ],

    'http' => [
        'enabled'              => true,
        'base_route'           => env('CODEX_BASE_ROUTE', null),
        'ignore_project_names' => [ '_debugbar', ],
        'api'                  => [
            'enabled'    => true,
            'middleware' => [ ],
            'tokens'     => [ ],
        ],
    ],

    'log' => true,

    'dev' => [
        'enabled'    => env('CODEX_DEV_ENABLED', false),
        'metas'      => true,
        'debugbar'   => true,
        'benchmark'  => true,
        'hookpoints' => true,
    ],

    'document' => [
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

    'processors' => [
        'macros' => [
            'table:responsive' => 'Codex\Processors\Macros\Table@responsive',
            'general:hide'     => 'Codex\Processors\Macros\General@hide',
            'attribute:print'  => 'Codex\Processors\Macros\Attribute@printValue',
        ],

        'links' => [
            // #codex:project:blade-extensions
            // #codex:project:blade-extensions:master
            // #codex:project:blade-extensions:master:configuration
            'project' => 'Codex\Processors\Links\Codex@project',
            'phpdoc'  => 'Codex\Addon\Phpdoc\PhpdocLink@handle',
        ],
    ],

    'apply_theme' => true,

    'plugins' => ['phpdoc', 'auth', 'git', 'jira' ],
//    'plugins' => ['phpdoc', 'auth', 'git', 'jira' , 'theme-default'],


    'default_project_config' => [
        'description' => '',
        'default'     => \Codex\Projects\Refs::DEFAULT_AUTO,
        'custom'      => null,
        'first'       => '',
        'index'       => 'index',
        'extensions'  => [ 'md', 'markdown', 'html' ],
        'processors'  => [
            'enabled' => [ ],
        ],
    ],

    'default_document_attributes' => [
        'author'     => 'John Doe',
        'title'      => '',
        'subtitle'   => '',
        'view'       => null,
        'cache'      => true,
        'processors' => [
            'enabled'  => [ ],
            'disabled' => [ ],
        ],
    ],

];
