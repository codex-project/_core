<?php

/*
 * Documentation: http://codex-project.dev/codex/master/getting-started/configuration
 */
return [

    'display_name' => env('CODEX_DISPLAY_NAME', 'Codex'),

    'default_project' => env('CODEX_DEFAULT_PROJECT', 'codex'),

    'paths' => [
        'docs'     => env('CODEX_ROOT_DIR', base_path('resources/docs')),
        'stubs'    => __DIR__ . '/../resources/stubs',
        'manifest' => storage_path('codex.json'),
    ],

    'routing' => [
        'enabled'              => true,
        'base_route'           => env('CODEX_BASE_ROUTE', 'codex'),
        'ignore_project_names' => [ '_debugbar', ],
    ],

    'api' => [
        'enabled' => true,
        'tokens'  => [ ],
    ],

    'log' => [
        'enabled' => true,
        'path'    => storage_path('logs/codex.log'),
    ],

    'dev' => [
        'enabled'      => env('CODEX_DEV_ENABLED', false),
        'debugbar'     => true,
        'log_handlers' => true,
        'print_events' => true,
    ],

    'extensions' => [
        'md'       => 'codex.document',
        'markdown' => 'codex.document',
        'html'     => 'codex.document',
        'rst'      => 'codex.document',
    ],

    'doctags' => [
        'table:responsive' => 'Codex\Addons\Processors\DocTags\Table@responsive',
        'general:hide'     => 'Codex\Addons\Processors\DocTags\General@hide',
        'attribute:print'  => 'Codex\Addons\Processors\DocTags\Attribute@printValue',
    ],

    'default_project_config' => [
        'description' => '',
        'default'     => \Codex\Projects\Project::SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH,
        'custom'      => null,
        'first'       => '',
        'index'       => 'index',
        'extensions'  => [ 'md', 'markdown', 'html' ],
        'processors'     => [
            'enabled' => [ ],
        ],
    ],

    'default_document_attributes' => [
        'author'          => 'John Doe',
        'title'           => '',
        'subtitle'        => '',
        'view'            => null,
        'disable_processors' => [ ],
        'buttons'         => [
        ],
        'processors'         => [
        ],
    ],

];
