<?php
namespace Codex\Addons;

use Codex\Addons\Scanner\ClassFileInfo;
use Codex\Contracts\Traits\Hookable;
use Codex\Exception\CodexException;
use Codex\Traits\HookableTrait;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;

abstract class AbstractAddonCollection extends \Illuminate\Support\Collection implements Hookable
{

    /** @var Addons */
    protected $addons;

    /** @var Application */
    protected $app;

    public function __construct($items = [ ], $addons = null)
    {
        parent::__construct($items);
        $this->app    = Container::getInstance();
        $this->addons = $addons ?: $this->app->make('codex.addons');
    }

    public function get($key, $default = null)
    {
        return data_get($this->items, $key, $default);
    }

    public function set($key, $value = null)
    {
        data_set($this->items, $key, $value);
    }

    public function whereHas($key, $value)
    {
        return $this->filter(function ($item) use ($key, $value)
        {
            return in_array($value, data_get($item, $key, [ ]), true);
        });
    }

    /** @deprecated */
    public function createProvider(ClassFileInfo $file, $instance = null)
    {
        $instance = $instance ?: app()->build($class = $file->getClassName());

        /** @noinspection PhpParamsInspection */
        $provider = new AddonServiceProvider($this->app);
        $provider->setAddon($instance);
        $path = $file->getPath();

        for ( $current = 0; $current < 4; $current++ )
        {
            if ( $this->addons->getFs()->exists(path_join($path, 'composer.json')) )
            {
                break;
            }
            $path = path_get_directory($path);
        }

        if ( $path === $file->getPath() )
        {
            throw CodexException::because('Could not resolve root dir');
        }

        $provider->setRootDir($path);

        if ( property_exists($instance, 'registerConfig') )
        {
            $provider->setConfigFiles((array)$instance->registerConfig);
        }

        if ( property_exists($instance, 'registerAssets') )
        {
            $provider->setAssetDirs((array)$instance->registerAssets);
        }

        if ( property_exists($instance, 'registerViews') )
        {
            $provider->setViewDirs((array)$instance->registerViews);
        }


        return $provider;
    }

}