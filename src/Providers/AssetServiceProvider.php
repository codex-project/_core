<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Providers;

use Sebwite\Assets\Traits\ProvidesAssets;
use Sebwite\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    use ProvidesAssets;

    protected function assets()
    {
        $this->area('codex/auth')
            ->group('global', [], true)
            ;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}
