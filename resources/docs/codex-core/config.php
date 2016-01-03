<?php

return [
    'display_name' => 'Codex :: Core',

    'hooks' => [
        'enabled' => [ 'phpdoc', 'git' ],
        'phpdoc'  => [
            'default_class' => '\\Codex\\Core\\CodexServiceProvider'
        ],
        'git' => [
            'owner'      => 'codex-project',
            'repository' => 'codex',
            'remote'     => 'github',
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
    ],
];
