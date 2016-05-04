<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addons;


use Codex\Core\Addons\Exception\AddonProviderException;
use Codex\Core\Codex;
use Codex\Core\CodexServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\ServiceProvider;
use Sebwite\Support\Str;

abstract class AddonServiceProvider extends ServiceProvider
{
    const MERGE_PROJECT = 'default_project_config';
    const MERGE_DOCUMENT = 'default_document_attributes';

    protected $name;

    protected $defaults = [ ];

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
        $this->handleAddonConfigFiles();
        $this->handleAddonDefaultConfig();
    }

    private function handleAddonConfigFiles()
    {
        $fileName = "codex-addon.{$this->name}";
        // ensure this config file is not already included.
        if ( $this->configFiles !== null && in_array($fileName, $this->configFiles, true) ) {
            return;
        }
        $fs          = $this->app->make('files');
        $searchPaths = [ 'config', 'resources/config', 'src/config' ];
        foreach ( $searchPaths as $searchPath ) {
            if ( $fs->exists($configFilePath = path_join($this->rootDir, $searchPath, $fileName) . '.php') ) {
                $this->registerConfigFiles($fileName, path_join($this->rootDir, $searchPath));
                $this->bootConfigFiles($fileName, path_join($this->rootDir, $searchPath));
                break;
            }
        }
    }

    private function handleAddonDefaultConfig()
    {
        $c        = $this->app->make('config');
        $base     = 'codex-addon.' . $this->getName();
        $defaults = [ ];


        if ( $this->defaults === null || $this->defaults === false ) {
            // skip
            return;
        } elseif ( $this->defaults === true || is_string($this->defaults) ) {
            //auto-resolve
            $base = is_string($this->defaults) ? Str::removeLeft($this->defaults, $base) : $base;

            if ( $c->has($base . '.' . static::MERGE_PROJECT) ) {
                $defaults[ 'project' ] = $base . '.' . static::MERGE_PROJECT;
            }
            if ( $c->has($base . '.' . static::MERGE_DOCUMENT) ) {
                $defaults[ 'document' ] = $base . '.' . static::MERGE_DOCUMENT;
            }
        } elseif ( is_array($this->defaults) ) {
            // resolve from custom
            $defaults = collect($this->defaults)->only('project', 'document')->transform(function ($item) use ($base) {
                $item = $base . '.' . Str::removeLeft($item, $base);
            })->toArray();
        }

        foreach ( $defaults as $type => $config ) {
            $this->mergeDefaultConfig($type, $config);
        }
    }

    private function mergeDefaultConfig($type, $config)
    {
        $c = $this->app->make('config');

        if ( $type === 'project' ) {
            $type = static::MERGE_PROJECT;
        } elseif ( $type === 'document' ) {
            $type = static::MERGE_DOCUMENT;
        }

        if ( ! in_array($type, [ static::MERGE_DOCUMENT, static::MERGE_PROJECT ], true) ) {
            return;
            //throw new InvalidArgumentException("Not a valid merge default config type [{$type}]");
        }

        if ( ! is_array($config) ) {
            $config = $c->get($config);
        }

        $this->hook('constructed', function (Codex $codex) use ($config) {
            $codex->mergeDefaultProjectConfig($config);
        });
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
        return in_array($this->getName(), config('codex.addons'), true);
    }


}
