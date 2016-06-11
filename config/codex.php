<?php


return [

    'display_name' => env('CODEX_DISPLAY_NAME', 'Codex'),

//    'docs_dir' => env('CODEX_ROOT_DIR', base_path('resources/docs')),

    'default_project' => env('CODEX_DEFAULT_PROJECT', 'codex'),

    'paths' => [
        'docs'     => env('CODEX_ROOT_DIR', base_path('resources/docs')),
        'stubs'    => __DIR__ . '/../resources/stubs',
        'manifest' => storage_path('codex.json'),
    ],

    'routing' => [
        'enabled'              => true,
        'base_route'           => env('CODEX_BASE_ROUTE', 'codex'),
        'ignore_project_names' => [
            '_debugbar',
        ],
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

//    'stubs_path' => __DIR__ . '/../resources/stubs',

//    'manifest_path' => storage_path('codex.json'),

    'extensions' => [
        'md'       => 'codex.document',
        'markdown' => 'codex.document',
        'html'     => 'codex.document',
    ],


    /*
    |--------------------------------------------------------------------------
    | DocTags filter : Global DocTags
    |--------------------------------------------------------------------------
    |
    | DocTags are comment strings that can be used to render additional
    |
    */

    'doctags'                     => [
        'table:responsive' => 'Codex\Addons\Filters\DocTags\Table@responsive',
        'general:hide'     => 'Codex\Addons\Filters\DocTags\General@hide',
        'attribute:print'    => 'Codex\Addons\Filters\DocTags\Attribute@printValue',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Project Configuration
    |--------------------------------------------------------------------------
    |
    | These are the default settings used to pre-populate all project
    | configuration files.
    |
    */
    'default_project_config'      => [
        'description' => '',
        'default'     => \Codex\Projects\Project::SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH,
        'custom'      => null,
        'first'       => '',
        'index'       => 'index',
        'extensions'  => [ 'md', 'markdown', 'html' ],
        'filters'     => [
            'enabled' => [ ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Document Attributes
    |--------------------------------------------------------------------------
    |
    | These values will be merged with any frontmatter attributes your
    | documentation pages may have. Feel free to add or remove any
    | attributes as you see fit for your documentation needs.
    |
    */
    'default_document_attributes' => [
        'author'          => 'John Doe',
        'title'           => '',
        'subtitle'        => '',
        'view'            => null,
        'disable_filters' => [ ],
        'buttons'         => [
        ],
        'filters'         => [
        ],
    ],

];
