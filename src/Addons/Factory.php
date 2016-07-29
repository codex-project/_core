<?php
namespace Codex\Addons;

use BadMethodCallException;
use Codex\Addons\Annotations;
use Codex\Addons\Scanner\ClassFileInfo;
use Codex\Addons\Scanner\ClassInspector;
use Codex\Dev\Dev;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Macroable;
use Sebwite\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * This is the class Addons.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method Collections\Hooks hooks(...$params)
 * @method Collections\Processors processors(...$params)
 * @method Collections\Views views(...$params)
 * @method Collections\Plugins plugins(...$params)
 *
 * @property Collections\Processors $processors
 * @property Collections\Hooks      $hooks
 * @property Collections\Views      $views
 * @property Collections\Plugins    $plugins
 *
 */
class Factory implements Arrayable
{
    use Macroable;

    const HOOK = 'hook';
    const PLUGIN = 'plugin';
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

    /** @var \Codex\Addons\Scanner */
    protected $scanner;

    /** @var \Illuminate\Foundation\Application */
    protected $app;

    protected $collections = [ 'processors', 'plugins', 'hooks', 'views' ];

    /** @var string */
    protected $manifestPath;

    /** @var Manifest */
    protected $manifest;

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    protected function __construct()
    {
        $this->app = Container::getInstance();

        $this->processors = new Collections\Processors([ ], $this);
        $this->hooks      = new Collections\Hooks([ ], $this);
        $this->views      = new Collections\Views([ ], $this);
        $this->plugins    = new Collections\Plugins([ ], $this);

        $this->reader   = new AnnotationReader();
        $this->fs       = new Filesystem();
        $this->manifest = Manifest::make()->load();
        $this->scanner  = new Scanner($this, $this->manifest, $this->reader, $this->fs);
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
            return $this->views->get($name);
        }
        $this->views->set($name, $view);
        return $this;
    }

    /**
     * Add a hook on the fly
     *
     * @param      $name
     * @param      $listener
     * @param bool $replace
     */
    public function hook($name, $listener, $replace = false)
    {
        $hook          = new Annotations\Hook();
        $hook->name    = $name;
        $hook->replace = $replace;
        $file          = debug_backtrace()[ 1 ][ 'file' ];
        $class         = debug_backtrace()[ 1 ][ 'class' ];
        $this->hooks->add($this->getClassFileInfo($file, $class), $hook, $listener);
    }

    protected function getClassFileInfo($file, $class)
    {
        $fileInfo      = new SplFileInfo($file, $file, $file);
        return new ClassFileInfo($fileInfo, new ClassInspector($class, $this->reader));
    }


    /**
     * Search file for matching addon annotations and automaticly resolve and add them into their collections
     *
     * @param \Codex\Addons\Scanner\ClassFileInfo $file
     */
    public function resolveAndRegister(ClassFileInfo $file)
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
            elseif ( $annotation instanceof Annotations\Plugin )
            {
                $this->plugins->add($file, $annotation);
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

    /**
     * Scan a file and resolve annotations
     *
     * @param $filePath
     *
     * @return bool
     */
    public function scanAndResolveFile($filePath)
    {
        $file = $this->scanner->scanFile($filePath);
        if ( $file instanceof ClassFileInfo )
        {
            $this->resolveAndRegister($file);
            return true;
        }
        return false;
    }

    public function scanAndResolveDirectory($path)
    {
        $registered = 0;
        foreach ( $this->scanner->scanDirectory($path) as $info )
        {
            $this->resolveAndRegister($info);
            $registered++;
        }
        return $registered;
    }

    public function scanAndResolveAddonPackages()
    {
        Dev::getInstance()->benchmark('Codex Addon Factory findAndRegisterAll');
        $files = $this->scanner->findAll();
        foreach ( $files as $file )
        {
            $this->resolveAndRegister($file);
        }
        Dev::getInstance()->addMessage(array_keys($this->registered));

        Dev::getInstance()->benchmark('-');
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
            'plugins'    => $this->plugins->toArray(),
            'views'      => $this->views->toArray(),
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
        return $this->manifest = Manifest::make()->setManifestPath($this->manifestPath)->load();
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
