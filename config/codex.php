<?php

// Documentation: http://codex-project.dev/codex/master/getting-started/configuration/global
return [

    'display_name' => env('CODEX_DISPLAY_NAME', 'Codex'),

    'default_project' => env('CODEX_DEFAULT_PROJECT', 'codex'),

    'paths' => [
        'docs'     => env('CODEX_ROOT_DIR', base_path('resources/docs')),
        'stubs'    => __DIR__ . '/../resources/stubs',
        'manifest' => storage_path('codex.json'),
        'log'      => storage_path('logs/codex.log'),
    ],

    'http' => [
        'enabled'              => true,
        'base_route'           => env('CODEX_BASE_ROUTE', 'codex'),
        'ignore_project_names' => [ '_debugbar', ],
        'api'                  => [
            'enabled'    => true,
            'middleware' => [ ],
            'tokens'     => [ ],
        ],
    ],

    'log' => true,

    'dev' => [
        'enabled'      => env('CODEX_DEV_ENABLED', false),
        'debugbar'     => true,
        'log_handlers' => true,
        'print_events' => true,
    ],

    'document' => [
        'cache'      => [
            'mode'    => null,
            'minutes' => 7,
        ],
        'extensions' => [
            'md'       => 'codex.document',
            'markdown' => 'codex.document',
            'html'     => 'codex.document',
            'rst'      => 'codex.document',
        ],
    ],

    'macros' => [
        'table:responsive' => 'Codex\Processors\Macros\Table@responsive',
        'general:hide'     => 'Codex\Processors\Macros\General@hide',
        'attribute:print'  => 'Codex\Processors\Macros\Attribute@printValue',
    ],

    'default_project_config' => [
        'description' => '',
        'default'     => \Codex\Projects\Project::SHOW_MASTER_BRANCH,
        'custom'      => null,
        'first'       => '',
        'index'       => 'index',
        'extensions'  => [ 'md', 'markdown', 'html' ],
        'processors'  => [
            'enabled' => [ ],
        ],
    ],

    'default_document_attributes' => [
        'author'             => 'John Doe',
        'title'              => '',
        'subtitle'           => '',
        'view'               => null,
        'disable_cache'      => false,
        'disable_processors' => [ ],
        'buttons'            => [
        ],
        'processors'         => [
        ],
    ],

];
