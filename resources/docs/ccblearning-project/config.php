<?php
return [
    'display_name' => 'CCBLearning :: Project',

    'hooks' => [
        'enabled' => [ 'phpdoc', 'git', 'auth' ],
        'git'    => [
            'owner'      => 'sebwite',
            'repository' => 'ccblearning',
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
        ],
        'phpdoc' => [
            'default_class' => '\\Ccblearning\\Courses\\CoursesServiceProvider'
        ],
        'auth'   => [
            'provider' => 'bitbucket',
            'allow'    => [
                'groups' => [ 'sebwite' ]
            ]
        ]
    ],
];
