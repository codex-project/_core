<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Support;

use Laradic\ServiceProvider\BaseServiceProvider;
use Laradic\ServiceProvider\Plugins as P;

class ServiceProvider extends BaseServiceProvider
{
    use
        P\Bindings,
        P\Commands,
        P\Config,
        P\Events,
        P\Facades,
        P\Helpers,
        P\Middleware,
        P\Paths,
        P\Providers,
        P\Resources;

}
