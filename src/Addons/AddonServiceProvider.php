<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addons;


use Codex\Core\Addons\Exception\AddonProviderException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

abstract class AddonServiceProvider extends ServiceProvider
{
    protected $name;

    protected $depends;

    protected $config;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $app->booting(function (Application $app) {
            $app['codex']->getAddons()->add($this);
        });
        if ( !property_exists($this, 'name') ) {
            throw AddonProviderException::namePropertyNotDefined();
        }

        $config = $this->config = new TreeBuilder();
        #$config->root('filters')->
    }

    protected function defineConfig($root)
    {
    }

    public function register()
    {
        return $this->app;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDepends()
    {
        return $this->depends;
    }


}
