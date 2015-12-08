<!---
title: Docit Documentation
subtitle: Overview   
-->


#### Composer
```JSON
"docit/docit": "~2.0"
```
  
  
#### Laravel
Add the ThemesServiceProvider to your config.
```php
'Docit\Core\DocitServiceProvider'
```
  
  
#### Publish
Publish the config and assets. Optionally, publish the views
```sh
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=assets
php artisan vendor:publish --tag=views
```
  
  
#### Create a project
```sh
php artisan docit:make
```
