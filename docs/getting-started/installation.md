<!---
title: Installation
author: Robin Radic
icon: fa fa-legal
-->

###### Composer
```JSON
"docit/docit": "~2.0"
```

###### Laravel
Add the ThemesServiceProvider to your config.
```php
'Docit\Core\DocitServiceProvider'
```

###### Publish
Publish the config and assets. Optionally, publish the views
```sh
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=assets
php artisan vendor:publish --tag=views
```

###### Basic configuration
By default Docit will 
```sh
```

