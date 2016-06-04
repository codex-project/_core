<!---
title: Installation and configuration
subtitle: Getting started
-->


# Installation and configuration

## Installation

### Stand-alone application

1. Create project
```bash
composer create-project codex/codex
```

2. Serve
```bash
php artisan serve
```

### Sub-component

1. Add to composer
```bash
composer require codex/core
```

2. Add service provider
```php
# config/app.php
return [
    // ...
    'providers' => [
        // ...
        Codex\CodexServiceProvider::class
    ]
];
```

3. Publish and configure the configuration file
```bash
php artisan vendor:publish --provider=Codex\Core\CodexServiceProvider --tag=config
```

4. Publish the asset files
```bash
php artisan vendor:publish --provider=Codex\Core\CodexServiceProvider --tag=public
```
        
5. Publish the view files (optional)        
```bash
php artisan vendor:publish --provider=Codex\Core\CodexServiceProvider --tag=views
```


## Configuration
