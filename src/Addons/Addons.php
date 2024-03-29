<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addons;

use BadMethodCallException;
use Codex\Addons\Annotations;
use Codex\Dev\Dev;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Traits\Macroable;
use Laradic\AnnotationScanner\Scanner\ClassFileInfo;
use Laradic\AnnotationScanner\Scanner\ClassInspector;
use Laradic\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * This is the class Addons.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method Collections\HookCollection hooks(...$params)
 * @method Collections\ProcessorCollection processors(...$params)
 * @method Collections\ViewCollection views(...$params)
 * @method Collections\PluginCollection plugins(...$params)
 *
 * @property Collections\ProcessorCollection $processors
 * @property Collections\HookCollection      $hooks
 * @property Collections\ViewCollection      $views
 * @property Collections\PluginCollection    $plugins
 *
 */
class Addons implements Arrayable
{
    use Macroable;

    /**
     *
     */
    const HOOK = 'hook';
    /**
     *
     */
    const PLUGIN = 'plugin';
    /**
     *
     */
    const PROCESSOR = 'processor';

    /** @var Addons */
    static protected $instance;

    /** @var \Codex\Support\Collection */
    protected $defaults;

    /** @var Resolver */
    protected $resolver;

    /** @var \Illuminate\Foundation\Application */
    protected $app;

    /** @var array */
    protected $collections = [ 'processors', 'plugins', 'hooks', 'views' ];

    /** @var string */
    protected $manifestPath;

    /** @var Manifest */
    protected $manifest;

    /** @var \Codex\Addons\Collections\ProcessorCollection */
    protected $processors;

    /** @var \Codex\Addons\Collections\HookCollection */
    protected $hooks;

    /** @var \Codex\Addons\Collections\ViewCollection */
    protected $views;

    /** @var \Codex\Addons\Collections\PluginCollection */
    protected $plugins;


    /**
     * Addons constructor.
     */
    protected function __construct()
    {
        $this->app = Application::getInstance();

        $this->processors = new Collections\ProcessorCollection([], $this);
        $this->hooks      = new Collections\HookCollection([], $this);
        $this->views      = new Collections\ViewCollection([], $this);
        $this->plugins    = new Collections\PluginCollection([], $this);

        $this->loadManifest();

        $this->resolver = new Resolver();
    }

    /**
     * __callStatic method
     *
     * @param       $method
     * @param array $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, array $parameters = [])
    {
        $instance = static::getInstance();
        if ( method_exists($instance, $method) ) {
            return call_user_func_array([ $instance, $method ], $parameters);
        }
        throw new BadMethodCallException("Method $method does not exist in class " . static::class);
    }

    /**
     * getInstance method
     * @return \Codex\Addons\Addons
     */
    public static function getInstance()
    {
        if ( static::$instance === null ) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * mergeDefaultProjectConfig method
     *
     * @param        $config
     * @param string $method
     */
    public function mergeDefaultProjectConfig($config, $method = 'array_replace_recursive')
    {
        $this->mergeDefaults('projects.default_config', $config, $method);
    }

    /**
     * mergeDefaults method
     *
     * @param $key
     * @param $config
     * @param $method
     */
    protected function mergeDefaults($key, $config, $method)
    {
        $config = is_array($config) ? $config : config($config, []);
        $this->app->booted(function ($app) use ($key, $config, $method) {
            $app[ 'codex' ]->setConfig($key, call_user_func_array($method, [ $app[ 'codex' ]->config($key), $config ]));
        });
    }

    /**
     * mergeDefaultDocumentAttributes method
     *
     * @param        $config
     * @param string $method
     */
    public function mergeDefaultDocumentAttributes($config, $method = 'array_replace_recursive')
    {
        $this->mergeDefaults('documents.default_attributes', $config, $method);
    }

    /**
     * scanAndResolveAddonPackages method
     */
    public function resolveAndRegisterAddons()
    {
        Dev::getInstance()->startMeasure('Addons::resolveAndRegisterAddons');
        foreach ( $this->manifest->get('addons.*.autoloads.*.path', []) as $path ) {
            $this->resolveAndRegisterDirectory($path);
        }
        Dev::getInstance()->stopMeasure('Addons::resolveAndRegisterAddons');
    }

    protected function dev()
    {
        return Dev::getInstance();
    }

    public function resolveAndRegisterDirectory($path)
    {

        if ( $this->getCachedHash($path) !== $this->getDirectoryHash($path) ) {
            $this->dev()->addMessage('non-cached', 'resolveAndRegisterDirectory');
            $resolves = [];
            foreach ( $this->resolver->scanAndResolveDirectory($path) as $resolved ) {
                $this->dev()->addMessage("[resolveAndRegisterDirectory] non-cached for {$path}");
                $resolves[] = $resolved->toArray();
                $this->registerResolved($resolved);
            }
            $this->cacheResolved($path, $resolves);
        } else {
            foreach ( $this->getCachedResolved($path) as $resolved ) {
                $this->dev()->addMessage("[resolveAndRegisterDirectory] cached for {$path}");
                $this->registerResolved($resolved);
            }
        }
    }

    protected function registerResolved(Resolved $resolved)
    {
        if ( $resolved->is(self::PROCESSOR) ) {
            $this->processors->add($resolved->getClassFileInfo(), $resolved->getAnnotation());
        } elseif ( $resolved->is(self::PLUGIN) ) {
            $this->plugins->add($resolved->getClassFileInfo(), $resolved->getAnnotation());
        } elseif ( $resolved->is(self::HOOK) ) {
            $this->hooks->add($resolved->getClassFileInfo(), $resolved->getAnnotation(), $resolved->getMethod());
        }
    }

    protected function getCachedResolved($path)
    {
        $resolves = [];
        foreach ( $this->manifest->get('resolved.' . $path, []) as $raw ) {
            $classFileInfo = $this->resolver->getClassFileInfo($raw[ 'file' ], $raw[ 'class' ]);
            $annotation    = new $raw[ 'annotationClass' ];
            foreach ( $raw[ 'annotation' ] as $k => $v ) {
                $annotation->{$k} = $v;
            }
            $resolved = new Resolved($raw[ 'type' ], $classFileInfo, $annotation);
            if ( isset($raw[ 'property' ]) ) {
                $resolved->setProperty($raw[ 'property' ]);
            }
            if ( isset($raw[ 'method' ]) ) {
                $resolved->setMethod($raw[ 'method' ]);
            }
            $resolves[] = $resolved;
        }
        return $resolves;
    }

    protected function cacheResolved($path, array $resolves)
    {
        $this->manifest
            ->set('scanned.' . $path, $this->getDirectoryHash($path))
            ->put('resolved.' . $path, $resolves)
            ->save();
        return $this;
    }

    protected function getCachedHash($path)
    {
        return $this->manifest->get('scanned.' . $path, '');
    }

    protected function getDirectoryHash($path)
    {
        $size = 0;
        $str  = '';
        foreach ( file_allFiles($path) as $file ) {
            /** @var \Symfony\Component\Finder\SplFileInfo $file */
            $size += $file->getSize();
            $str .= $file->getFilename();
        }
        return md5($str . $size);
    }


    /**
     * toArray method
     * @return array
     */
    public function toArray()
    {
        return [
            'processors' => $this->processors->toArray(),
            'hooks'      => $this->hooks->toArray(),
            'plugins'    => $this->plugins->toArray(),
            'views'      => $this->views->toArray(),
        ];
    }

    /**
     * @return mixed
     */
    public function getManifestPath()
    {
        return $this->manifestPath;
    }

    /**
     * @param mixed $manifestPath
     */
    public function setManifestPath($manifestPath)
    {
        $this->manifestPath = $manifestPath;
        $this->loadManifest();
    }

    /**
     * loadManifest method
     * @return static
     */
    protected function loadManifest()
    {
        $this->manifest = Manifest::make()->setManifestPath($this->manifestPath)->load();
        return $this;
    }

    /**
     * @return Manifest
     */
    public function getManifest()
    {
        if ( null === $this->manifest || $this->manifest->isEmpty() ) {
            $this->loadManifest();
        }
        return $this->manifest;
    }

    /**
     * @return \Codex\Addons\Resolver
     */
    public function getResolver()
    {
        return $this->resolver;
    }


    /**
     * __call method
     *
     * @param       $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters = [])
    {
        if ( in_array($method, $this->collections, true) ) {
            $collection = $this->{$method};
            $args       = count($parameters);
            if ( $args === 0 ) {
                return $collection;
            } else {
                $method = array_shift($parameters);
                return call_user_func_array([ $collection, $method ], $parameters);
            }
        }
        throw new BadMethodCallException("Method $method does not exist in class " . get_class($this));
    }

    /**
     * __get method
     *
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ( in_array($name, $this->collections, true) ) {
            return $this->{$name};
        }
        throw new \RuntimeException("property $name not found");
    }
}
