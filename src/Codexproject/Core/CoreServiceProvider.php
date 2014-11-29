<?php namespace Codexproject\Core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $storageDriver = $this->app['config']->get('codex::driver');

        $this->app->bind('CodexRepositoryInterface', '\Codexproject\Core\Repository\\'.$storageDriver);
	}

    public function boot()
    {
        $this->package('codexproject/core', 'codex');

        // include the routes
        include __DIR__ . '../../routes.php';
    }
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
