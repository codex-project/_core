<?php

return [
    'display_name' => 'Sebwite :: Database',

    'hooks' => [
        'enabled' => [ 'phpdoc', 'git'],

        'phpdoc'  => [
            'default_class' => '\\Docit\\Support\\ServiceProvider'
        ],

        'git'     => [
            'owner'      => 'sebwitepackages',
            'repository' => 'sebwite-database',
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
