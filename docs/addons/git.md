<!--
title: Git
subtitle: Addons
-->

# Git

## Overview
The Git addon provides Github/Bitbucket integration featuring:

- Projects can be configured to retreive documentation from Github or Bitbucket repositories
- Webhook that automaticaly syncs your project whenever you push changes
- Specify branches and version constraints to filter what should be synced 

There are a few more features that have not yet been integrated but will be in future updates:
 
- A Markdown editor using Github/Bitbucket API by using Ace editor
- Stars, forks, pull requests, issues, etc can be configured to show on specified locations/documents.

## Getting started

### Installation

1. Installing the Git addon is done by using Composer to first download the package.
```bash
composer require codex/git-addon
```

2. You will have to register the [`GitServiceProvider`](#phpdoc:popover:Codex\Addon\Git\GitServiceProvider)
```php
return [
    'providers' => [
        //...
        Codex\Addon\Git\GitServiceProvider::class
    ]
];
```

3. Publish the configuration for the addon
```bash
php artisan vendor:publish --provider=Codex\Addon\Git\GitServiceProvider
```

### Configuration

#### Service
Alter the `config/services.php` file to include your connections. An example is shown below.

> The Git addon uses `sebwite/git` for API communication. Refer to its documentation to learn more about the available authentication methods available.
 
```php
return [
    // ...
    'github' => [
        'driver' => 'github',
        'auth'   => Sebwite\Git\Manager::AUTH_TOKEN,
        'secret' => env('GITHUB_SECRET', '')
    ],
    'bitbucket' => [
        'driver'      => 'bitbucket',
        'auth'   => Sebwite\Git\Manager::AUTH_OAUTH,
        'key'    => env('BITBUCKET_KEY', ''),
        'secret' => env('BITBUCKET_SECRET', '')
    ],
    'bitbucket2' => [
        'driver'      => 'bitbucket',
        'auth'   => Sebwite\Git\Manager::AUTH_BASIC,
        'key'    => env('BITBUCKET_KEY2', ''),
        'secret' => env('BITBUCKET_SECRET2', '')
    ],
]; 
```

#### Project
A example of a projects git addon configuration. 
```php
return [
    'display_name' => 'Codex',
    'filters' => [
        'enabled' => [ 'attributes', 'markdown', 'toc', 'replace_header', 'phpdoc', 'doctags' ],
    ],
    'git' => [
        'enabled'    => true,
        'owner'      => 'codex-project',
        'repository' => 'core',
        'connection' => 'github',           // github, bitbucket, bitbucket2
        'sync'       => [
            'constraints' => [
                'branches' => [ 'master' ],
                'versions' => '>=2.0.0',    // '1.x || >=2.5.0 || 5.0.0 - 7.2.3' (aka tags) 
            ],
            'paths'       => [
                'docs'  => 'docs',
                'menu'  => 'docs/menu.yml',
                'index' => 'docs/index.md',
            ],
        ],
        'webhook'    => [
            'enabled' => true,
            'secret'  => 'asorR#2jopwr'   // required for github only
        ],
    ],
];
```

## Commands
#### codex:git:sync
This will sync the project with Codex

`php artisan codex:git:sync {projectName?}`

## Webhook
Working. Just need to finish this documentation..

## Ajax/REST API

**Example URL:**
GET `http://localhost/phpdoc/<project>/<version>/<endpoint>?param=value`

##### entity
- entity (string) 

##### list
- full (boolean, optional, default=false)
 
##### tree
- full (boolean, optional, default=false)

##### source
- entity (string)

##### doc
- entity (string)

##### popover
- name (string)

