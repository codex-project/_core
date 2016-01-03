<?php

return [
    'display_name' => 'Sebwite :: Assets',

    'hooks' => [
        'enabled' => [ 'phpdoc' ],

        'phpdoc'  => [
            'default_class' => '\\Sebwite\\Assets\\AssetsServiceProvider'
        ],

        'git'     => [
            'owner'      => 'sebwitepackages',
            'repository' => 'sebwite-assets',
            'remote'     => 'bitbucket',
            'sync'       => [
                'constraints' => [
                    'branches' => [ 'master' ],
                    'versions' => '*', //1.x || >=2.5.0 || 5.0.0 - 7.2.3'
                ],
                'paths'       => [
                    'docs' => 'docs',
                    'menu' => 'docs/menu.yml'
                ]
            ],
            'webhook'    => [
                'enabled' => true
            ],
        ]
    ]
];
