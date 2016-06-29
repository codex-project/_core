<?php
namespace Codex\Addons;

use BadMethodCallException;
use Codex\Addons\Annotations;
use Codex\Addons\Collections\Hooks;
use Codex\Addons\Collections\Processors;
use Codex\Addons\Scanner\ClassFileInfo;
use Codex\Dev\Dev;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Macroable;
use Sebwite\Filesystem\Filesystem;

/**
 * This is the class Addons.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method Hooks hooks(...$params)
 * @method Processors processors(...$params)
 *
 * @property Processors $processors
 * @property Hooks      $hooks
 *
 */
class Factory implements Arrayable
{
    use Macroable;

    const HOOK = 'hook';
    const THEME = 'theme';
    const PROCESSOR = 'processor';

    /** @var Factory */
    static protected $instance;

    /** @var \Codex\Support\Collection */
    protected $processors;


    /** @var \Codex\Support\Collection */
    protected $hooks;

    /** @var \Codex\Support\Collection */
    protected $defaults;

    /** @var \Sebwite\Filesystem\Filesystem */
    protected $fs;

    protected $paths;

    protected $registered = [ ];

    protected $scanner;

    /** @var \Illuminate\Foundation\Application */
    protected $app;

    protected $views = [
        'layouts'    => [
            'base'    => 'codex::layouts.base',
            'default' => 'codex::layouts.default',
        ],
        'layout'     => 'codex::layouts.default',
        'document'   => 'codex::document',
        'error'      => 'codex::error',
        'menus'      => [
            'sidebar'  => 'codex::menus.sidebar',
            'projects' => 'codex::menus.header-dropdown',
            'versions' => 'codex::menus.header-dropdown',
        ],
        'processors' => [
            'header'  => 'codex::processors.header',
            'toc'     => 'codex::processors.toc',
            'buttons' => 'codex::processors.buttons',
        ],
    ];

    protected $collections = [ 'processors', 'themes', 'hooks' ];

    /** @var string */
    protected $manifestPath;

    /** @var Manifest */
    protected $manifest;

    protected function __construct()
    {
        $this->processors = new Processors([ ], $this);
        $this->hooks      = new Hooks([ ], $this);

        $this->scanner = new Scanner($this);
        $this->fs      = new Filesystem();
        $this->app     = Container::getInstance();
    }

    public static function __callStatic($method, array $parameters = [ ])
    {
        $instance = static::getInstance();
        if ( method_exists($instance, $method) )
        {
            return call_user_func_array([ $instance, $method ], $parameters);
        }
        throw new BadMethodCallException("Method $method does not exist in class " . static::class);
    }

    public static function getInstance()
    {
        if ( static::$instance === null )
        {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function view($name, $view = null)
    {
        if ( $view === null )
        {
            return data_get($this->views, $name);
        }
        data_set($this->views, $name, $view);
        return $this;
    }

    public function register(ClassFileInfo $file)
    {
        $class = $file->getClassName();
        if ( array_key_exists($class, $this->registered) )
        {
            return;
        }
        $this->registered[ $class ] = $file;
        foreach ( $file->getClassAnnotations() as $annotation )
        {
            if ( $annotation instanceof Annotations\Processor )
            {
                $this->processors->add($file, $annotation);
            }
            elseif ( $annotation instanceof Annotations\Hook )
            {
                $this->hooks->add($file, $annotation);
            }
        }
        foreach ( $file->getMethodAnnotations(true) as $method => $annotations )
        {
            foreach ( $annotations as $annotation )
            {
                if ( $annotation instanceof Annotations\Hook )
                {
                    $this->hooks->add($file, $annotation, $method);
                }
            }
        }
        foreach ( $file->getPropertyAnnotations(true) as $property => $annotations )
        {
            foreach ( $annotations as $annotation )
            {
            }
        }
    }

    public function registerAtPath($filePath)
    {
        $file = $this->scanner->scanFile($filePath);
        if ( $file instanceof ClassFileInfo )
        {
            $this->register($file);
            return true;
        }
        return false;
    }

    public function registerInPath($path)
    {
        $registered = 0;
        foreach ( $this->scanner->scanDirectory($path) as $info )
        {
            $this->register($info);
            $registered++;
        }
        return $registered;
    }

    public function findAndRegisterAll()
    {
        Dev::getInstance()->benchmark('a');
        foreach ( $this->scanner->findAll() as $file )
        {
            $this->register($file);
        }
        Dev::getInstance()->benchmark('b');
        #codex()->dev->stopMeasure('Codex\Addons\Factory::findAndRegisterAll');
    }

    public function mergeDefaultProjectConfig($config, $method = 'array_replace_recursive')
    {
        $this->mergeDefaults('default_project_config', $config, $method);
    }

    protected function mergeDefaults($key, $config, $method)
    {
        $config = is_array($config) ? $config : config($config);
        $this->app->booted(function ($app) use ($key, $config, $method)
        {
            $app[ 'codex' ]->setConfig($key, call_user_func_array($method, [ $app[ 'codex' ]->config($key), $config ]));
        });
    }

    public function mergeDefaultDocumentAttributes($config, $method = 'array_replace_recursive')
    {
        $this->mergeDefaults('default_document_attributes', $config, $method);
    }

    public function toArray()
    {
        return [
            'processors' => $this->processors->toArray(),
            'hooks'      => $this->hooks->toArray(),
            'views'      => $this->views,
        ];
    }

    /**
     * @return Filesystem
     */
    public function getFs()
    {
        return $this->fs;
    }

    /**
     * @return \Codex\Addons\Scanner
     */
    public function getScanner()
    {
        return $this->scanner;
    }

    /**
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @return array
     */
    public function getRegistered()
    {
        return $this->registered;
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

    protected function loadManifest()
    {
        return $this->manifest = Manifest::make($this->manifestPath);
    }

    /**
     * @return Manifest
     */
    public function getManifest()
    {
        if ( isset($this->manifest) === false )
        {
            $this->loadManifest();
        }
        return $this->manifest;
    }

    public function __call($method, array $parameters = [ ])
    {
        if ( in_array($method, $this->collections, true) )
        {
            $collection = $this->{$method};
            $args       = count($parameters);
            if ( $args === 0 )
            {
                return $collection;
            }
            else
            {
                $method = array_shift($parameters);
                return call_user_func_array([ $collection, $method ], $parameters);
            }
        }
        throw new BadMethodCallException("Method $method does not exist in class " . get_class($this));
    }

    public function __get($name)
    {
        if ( in_array($name, $this->collections, true) )
        {
            return $this->{$name};
        }
        throw new \RuntimeException("property $name not found");
    }
}
