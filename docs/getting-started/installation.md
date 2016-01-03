<!---
title: Installation
author: Robin Radic
icon: fa fa-legal
-->

###### Composer
```JSON
"codex/codex": "~2.0"
```

###### Laravel
Add the ThemesServiceProvider to your config.
```php
'Codex\Core\CodexServiceProvider'
```

###### Publish
Publish the config and assets. Optionally, publish the views
```sh
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=assets
php artisan vendor:publish --tag=views
```

###### Basic configuration
By default Codex will 
```sh
```

