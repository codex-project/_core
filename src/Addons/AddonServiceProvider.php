<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addons;


use Codex\Core\Addons\Exception\AddonProviderException;
use Codex\Core\CodexServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\ServiceProvider;

abstract class AddonServiceProvider extends ServiceProvider
{
    protected $name;

    protected $asdf;

    protected $depends = [];

    protected $config = [];

    public function __construct(Application $app)
    {
        parent::__construct($app);

        // make sure the codex services are registered before we register our own stuff
        $this->providers[] = CodexServiceProvider::class;

        if ( !property_exists($this, 'name') || $this->name === null ) {
            throw AddonProviderException::namePropertyNotDefined();
        }
    }

    public function booted()
    {
        $this->app['codex.addons']->add($this);
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string[]|array
     */
    public function getDepends()
    {
        return $this->depends;
    }

    protected function hook($name, $listener)
    {
        $this->app[ 'codex.addons' ]->hook($name, $listener);
    }

    protected function theme($name, $views = [ ])
    {
        $this->app['codex.addons']->registerTheme($name, $views);
    }

    public function isEnabled()
    {
        return true;
    }



}
