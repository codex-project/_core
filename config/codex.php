<?php


return [
    'display_name'    => env('CODEX_DISPLAY_NAME', 'Codex'),
    'docs_dir'        => env('CODEX_ROOT_DIR', base_path('resources/docs')),
    'routing'         => [
        'enabled'              => true,
        'base_route'           => env('CODEX_BASE_ROUTE', 'codex'),
        'provider'             => 'Codex\\Core\\Providers\\RouteServiceProvider',
        'ignore_project_names' => [
            '_debugbar',
        ],
    ],
    'log'             => [
        'enabled' => true,
        'path'    => storage_path('logs/codex.log'),
    ],
    'dev'             => [
        'enabled'      => env('CODEX_DEV_ENABLED', false),
        'debugbar'     => true,
        'log_handlers' => true,
        'print_events' => true,
    ],
    'stubs_path'      => __DIR__ . '/../resources/stubs',
    'default_project' => env('CODEX_DEFAULT_PROJECT', 'codex'),

    'theme'                       => 'laravel', // null, 'laravel', 'angular', 'material'

    /*
    |--------------------------------------------------------------------------
    | Default Project Attributes
    |--------------------------------------------------------------------------
    |
    | These values will be merged with any frontmatter attributes your
    | documentation pages may have. Feel free to add or remove any
    | attributes as you see fit for your documentation needs.
    |
    */
    'default_document_attributes' => [
        'author'   => 'John Doe',
        'title'    => 'Documentation',
        'subtitle' => '',
        'layout'   => 'codex::layouts.document',
        'view'     => 'codex::document',
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
        'default'     => \Codex\Core\Projects\Project::SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH,
        'custom'      => null,
        'filters'     => [
            'enabled' => [ ], // 'front_matter', 'parsedown'
            'front_matter' => [ ],
            'parsedown'    => [ 'fenced_code_lang_class' => 'hljs lang-{LANG}'], //'prettyprint lang-{LANG}'
        ],
        'hooks'       => [
            'enabled' => [ ],
            // '{hookName}' => [ hookSettings ]
        ],
    ],

];
