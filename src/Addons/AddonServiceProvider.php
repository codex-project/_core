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

    protected $depends = [ ];

    protected $scanDirs = true;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        // make sure the codex services are registered before we register our own stuff
        $this->providers[] = CodexServiceProvider::class;

        // Ensure the 'name' property exists and is set.
        if ( ! property_exists($this, 'name') || $this->name === null ) {
            throw AddonProviderException::namePropertyNotDefined();
        }
    }

    public function booted()
    {
        $this->app[ 'codex.addons' ]->add($this);
    }

    public function booting()
    {
        $fileName = "codex-addon.{$this->name}";
        // ensure this config file is not already included.
        if ( $this->configFiles !== null && in_array($fileName, $this->configFiles, true) ) {
            return;
        }
        $fs          = $this->app->make('files');
        $searchPaths = [ 'config', 'resources/config', 'src/config' ];
        foreach ( $searchPaths as $searchPath ) {
            if ( $fs->exists($configFilePath = path_join($this->rootDir, $searchPath, $fileName)) ) {
                $this->registerConfigFiles($fileName, path_join($this->rootDir, $searchPath));
                $this->bootConfigFiles($fileName, path_join($this->rootDir, $searchPath));
                break;
            }
        }
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
        $this->app[ 'codex.addons' ]->registerTheme($name, $views);
    }

    /**
     * isEnabled method
     * @return bool
     */
    public function isEnabled()
    {
        return true;
    }


}
