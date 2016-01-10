<!---
title: Codex Documentation
subtitle: Installation and configuration   
-->


Installation
------------
1. Add to composer

		composer require codex/phpdoc-hook

2. Add service provider

		Codex\Hooks\Phpdoc\HookServiceProvider::class

3. Publish and configure the configuration file

		php artisan vendor:publish --provider=Codex\Hooks\Phpdoc\HookServiceProvider --tag=config

4. Publish the asset files

        php artisan vendor:publish --provider=Codex\Hooks\Phpdoc\HookServiceProvider --tag=public
        
5. Publish the view files (optional)        

        php artisan vendor:publish --provider=Codex\Hooks\Phpdoc\HookServiceProvider --tag=views

6. Check the [documentation](http://codex-project.ninja/auth-hook) for more!

