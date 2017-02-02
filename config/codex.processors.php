<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */

return [
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
            'table:responsive'        => 'Codex\Processors\Macros\Table@responsive',
            'layout:row'              => 'Codex\Processors\Macros\Layout@row',
            'layout:column'              => 'Codex\Processors\Macros\Layout@column',
            'general:hide'            => 'Codex\Processors\Macros\General@hide',
            'attribute:print'         => 'Codex\Processors\Macros\Attribute@printValue',
            'phpdoc:method:signature' => 'Codex\Addon\Phpdoc\Macros@methodSignature',
            'phpdoc:method'           => 'Codex\Addon\Phpdoc\Macros@method',
            'phpdoc:entity'           => 'Codex\Addon\Phpdoc\Macros@entity',
            'phpdoc:list:method'      => 'Codex\Addon\Phpdoc\Macros@listMethod',
            'phpdoc:list:property'    => 'Codex\Addon\Phpdoc\Macros@listProperty',
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
];
