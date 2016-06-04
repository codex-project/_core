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

4. Alter the `config/services.php` file to include your connections
The Git addon uses `sebwite/git` for API communication. 
5. Refer to its documentation to learn more about the available `auth` methods available. 
6. For example, both Bitbucket and Github can be configured to use BASIC auth. 
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
]; 
```

### Configuration

## Usage in project

## Javascript 
```javascript
$.phpdoc.api

## Ajax/REST API

**Example URL:**
GET `http://localhost/phpdoc/<project>/<version>/<endpoint>?param=value`


### Endpoints

#### entity
- entity (string) 

#### list
- full (boolean, optional, default=false)
 
#### tree
- full (boolean, optional, default=false)

#### source
- entity (string)

#### doc
- entity (string)

#### popover
- name (string)

