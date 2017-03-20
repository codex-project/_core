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
    // This will be used for the <title> and for the header
    'display_name'    => env('CODEX_DISPLAY_NAME', 'Codex (BETA)'),


    'description'     => 'Codex is a file-based documentation platform built on top of Laravel. It\'s completely customizable and dead simple to use to create beautiful documentation.',

    // The default project. Will be used when, for example, you do not specify the project name in the URL
    'default_project' => env('CODEX_DEFAULT_PROJECT', 'codex'),

    // enabled plugins
    'plugins'         => [ 'phpdoc', 'auth', 'git', 'jira', 'welcome' ],

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

    'projects' => [

        'default_config' => [
            'description' => '',
            // default ref
            'default'     => \Codex\Projects\Refs::DEFAULT_AUTO,
//            'first'       => '',
            // default document
            'index'       => 'index',
            'extensions'  => [ 'md', 'markdown', 'html' ],
            // set default view for document. leave on null to let $codex->view('document') be it
            'view'        => null,
            'processors'  => [
                'enabled' => [],
            ],
        ],
    ],

    'refs' => [
        'inherit_config' => [
            'index',
            'processors',
            'view',
        ],
        // the default values of codex.yml
        'default_config' => [
            // inherits from project:
            // index
            // processors
            // view

            'menu' => false,
        ],
    ],

    'documents' => [
        'cache'              => [
            // true     = enabled
            // false    = disabled
            // null     = disabled when app.debug is true
            'mode'    => \Codex\Documents\Document::CACHE_AUTO,


            // Whenever a document's last modified time changes, the document's cache is refreshed.
            // It is possible to set this to null making it refresh by checking last modified.
            // Alternatively, you can also set a max duration in minutes.
            // Recommended is to put it on null
            'minutes' => 7,
        ],
        'extensions'         => [
            'md'       => 'codex.document',
            'markdown' => 'codex.document',
            'html'     => 'codex.document',
            'rst'      => 'codex.document',
        ],
        'inherit_attributes' => [
            'processors',
            'view',
        ],
        'default_attributes' => [
            'author'   => '',
            'title'    => '',
            'subtitle' => '',
            'cache'    => true,
            // inherits from refs codex.yml
            // processors
        ],
    ],

];
