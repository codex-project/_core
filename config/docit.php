<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Display name
    |--------------------------------------------------------------------------
    |
    */
    'display_name' => 'Docit',

    /*
    |--------------------------------------------------------------------------
    | Root directory
    |--------------------------------------------------------------------------
    |
    */
    'root_dir' => env('CODEX_ROOT_DIR', base_path('resources/docs')),

    /*
    |--------------------------------------------------------------------------
    | Route Base
    |--------------------------------------------------------------------------
    |
    | You may define a base route for your Docit documentation here. By default
    | it is set to "docit", but you may leave this empty if you wish to use
    | Docit as a stand alone application.
    |
    */
    'base_route' => env('CODEX_BASE_ROUTE', 'docit'),

    /*
    |--------------------------------------------------------------------------
    | Default Project
    |--------------------------------------------------------------------------
    |
    */
    'default_project' => env('CODEX_DEFAULT_PROJECT', 'docit'),

    /*
    |--------------------------------------------------------------------------
    | Project menus view composer
    |--------------------------------------------------------------------------
    |
    */
    'projects_menus_view_composer' => 'Docit\\Docit\\Http\\ViewComposers\\ProjectMenusComposer',

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
        'author' => 'John Doe',
        'title' => 'Documentation',
        'subtitle' => '',
        'layout' => 'docit::layouts/default',
        'view' => 'docit::document'
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
    'default_project_config' => [
        'description'      => '',
        'default'          => Docit\Core\Project::SHOW_LAST_VERSION_OTHERWISE_MASTER_BRANCH,
        'custom'           => null,
        'filters'          => ['front_matter', 'parsedown'],
        'filters_settings' => [
            'front_matter' => [],
            'parsedown' => [
                'fenced_code_lang_class' => 'hljs lang-{LANG}'//'prettyprint lang-{LANG}'
            ]
        ]
    ]
];
