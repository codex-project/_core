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
            'mode'    => true,


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


    /*
    |--------------------------------------------------------------------------
    | Processors
    |--------------------------------------------------------------------------
    |
    | Global/default configuration for processors. Processors are applied
    | to a document it's raw content. It modifies the final rendered output.
    |
    | This configuration can be overridden on project level, and is the
    |  preferred way.
    |
    */
    'processors' => [
        'attributes' => [
            'tags'           => [
                [ 'open' => '<!--*', 'close' => '--*>' ], // html, markdown
                [ 'open' => '---', 'close' => '---' ], // markdown (frontmatter)
            ],
            'remove_tags'    => true,
            'add_extra_data' => true,
        ],
        'buttons'    => [
            'type'                => 'groups',
            'groups'              => [
//            'group-id' => [
//                'button-id' => [
//                    'text'   => 'Haai',
//                    'href'   => 'http://goto.com/this',
//                    'target' => '_blank',
//                ],
//            ]
            ],
            'buttons'             => [
//            'button-id' => [
//                'text'   => 'Haai',
//                'icon' => 'fa fa-github',
//                'attr' => [
//                    'href'   => 'http://goto.com/this',
//                    'target' => '_blank',
//                ]
//            ],
            ],
            'wrapper_class'       => 'top-buttons',
            'group_wrapper_class' => 'top-button-group',

        ],
        'header'     => [
            'view'                 => 'processors.header',
            'remove_from_document' => true,
            'remove_regex'         => '/<h1>(.*?)<\/h1>/',
        ],
        'links'      => [
            'needle' => 'codex',
            'links'  => [
                // #codex:project:blade-extensions
                // #codex:project:blade-extensions:master
                // #codex:project:blade-extensions:master:configuration
                'project' => 'Codex\Processors\Links\Codex@project',
                'phpdoc'  => 'Codex\Addon\Phpdoc\PhpdocLink@handle',

            ],
        ],
        'macro'      => [

            'macros' => [
                'table:responsive' => 'Codex\Processors\Macros\Table@responsive',
                'general:hide'     => 'Codex\Processors\Macros\General@hide',
                'attribute:print'  => 'Codex\Processors\Macros\Attribute@printValue',
            ],
        ],
        'parser'     => [
            'parser'   => 'Codex\Processors\Parser\MarkdownParser', // the parser with name 'markdown'
            'markdown' => [ // refers to parser name
                'renderer' => 'Codex\Processors\Parser\Markdown\CodexMarkdownRenderer',
                // additional custom config possible for the renderer
            ],

        ],
        'prismjs'    => [
            'js_path'     => '/vendor/codex/vendor/prismjs/prism.js',
            'css_path'    => '/vendor/codex/styles/prismjs.css', // 'vendor/codex/vendor/prismjs/themes/prism.css',
            'plugin_path' => '/vendor/codex/vendor/prismjs/plugins',
            'plugins'     => [
                'enabled' => [
                    'autolinker',
                    'autoloader',
                    'command-line',
                    'copy-to-clipboard',
                    'toolbar',
                    'line-highlight',
                    'line-numbers',
                    'show-language',
                    'wpd',
                ],
                'config'  => [
                    'autolinker'               => [],
                    'autoloader'               => [
                        'javascript' => [
                            'languages_path' => '/vendor/codex/vendor/prismjs/components/',
                            'use_minified'   => true,
                        ],
                    ],
                    'command-line'             => [
                        'data-user'   => false,
                        'data-host'   => false,
                        'data-prompt' => 'admin@local $',
                        'data-output' => false,
                    ],
                    'copy-to-clipboard'        => [],
                    'custom-class'             => [],
                    'data-uri-highlight'       => [],
                    'file-highlight'           => [],
                    'highlight-keywords'       => [],
                    'ie8'                      => [],
                    'jsonp-highlight'          => [],
                    'keep-markup'              => [],
                    'line-highlight'           => [],
                    'line-numbers'             => [],
                    'normalize-whitespace'     => [],
                    'previewer-angle'          => [],
                    'previewer-base'           => [],
                    'previewer-color'          => [],
                    'previewer-easing'         => [],
                    'previewer-gradient'       => [],
                    'previewer-time'           => [],
                    'remove-initial-line-feed' => [],
                    'show-invisibles'          => [],
                    'show-language'            => [],
                    'toolbar'                  => [],
                    'unescaped-markup'         => [],
                    'wpd'                      => [],


                ],
            ],

        ],
        'toc'        => [
            'disable'           => [ 1 ],
            'regex'             => '/<h(\d)>([\w\W]*?)<\/h\d>/',
            'list_class'        => 'toc',
            'header_link_class' => 'toc-header-link',
            'header_link_show'  => false,
            'header_link_text'  => '#',
            'minimum_nodes'     => 2,
            'view'              => 'processors.toc',
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
