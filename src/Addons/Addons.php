<?php
namespace Codex\Core\Addons;

use BadMethodCallException;
use Codex\Core\Addons\Annotations;
use Codex\Core\Addons\Scanner\ClassFileInfo;
use Illuminate\Container\Container;
use Illuminate\Support\Traits\Macroable;
use Sebwite\Filesystem\Filesystem;

/**
 * This is the class Addons.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method HookAddons hooks(...$params)
 * @method FilterAddons filters(...$params)
 * @method ThemeAddons themes(...$params)
 * @method DefaultsAddons defaults(...$params)
 *
 * @property FilterAddons   $filters
 * @property HookAddons     $hooks
 * @property ThemeAddons    $themes
 * @property DefaultsAddons $defaults
 *
 */
class Addons
{
    use Macroable;


    const HOOK = 'hook';
    const THEME = 'theme';
    const FILTER = 'filter';


    /** @var Addons */
    static protected $instance;

    /** @var \Codex\Core\Support\Collection */
    protected $filters;

    /** @var \Codex\Core\Support\Collection */
    protected $themes;

    /** @var \Codex\Core\Support\Collection */
    protected $hooks;

    /** @var \Codex\Core\Support\Collection */
    protected $defaults;

    /** @var \Sebwite\Filesystem\Filesystem */
    protected $fs;

    protected $paths;

    protected $manifestPath;

    protected $registered = [ ];

    protected $scanner;

    protected $app;


    protected function __construct()
    {
        $this->filters  = new FilterAddons([ ], $this);
        $this->hooks    = new HookAddons([ ], $this);
        $this->defaults = new DefaultsAddons([ ], $this);
        $this->themes   = new ThemeAddons([ ], $this);
        $this->scanner  = new AddonScanner();
        $this->fs       = new Filesystem();
        $this->app      = Container::getInstance();

        $this->registerInPath(__DIR__ . '/Filters');
        $this->themes->hookTheme();
    }

    public static function getInstance()
    {
        if ( static::$instance === null ) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function findAndRegisterAll()
    {
        foreach ( $this->scanner->findAll() as $file ) {
            $this->register($file);
        }
    }

    public function register(ClassFileInfo $file)
    {
        $class = $file->getClassName();
        if ( array_key_exists($class, $this->registered) ) {
            return;
        }
        $this->registered[ $class ] = $file;
        foreach ( $file->getClassAnnotations() as $annotation ) {
            if ( $annotation instanceof Annotations\Filter ) {
                $this->filters->add($file, $annotation);
            } elseif ( $annotation instanceof Annotations\Hook ) {
                $this->hooks->add($file, $annotation);
            } elseif ( $annotation instanceof Annotations\Theme ) {
                $this->themes->add($file, $annotation);
            }
        }
        foreach ( $file->getMethodAnnotations() as $method => $annotations ) {
            if ( count($annotations) === 0 ) {
                continue;
            }
            foreach ( $annotations as $annotation ) {
                if ( $annotation instanceof Annotations\Hook ) {
                    $this->hooks->add($file, $annotation, $method);
                } elseif ( $annotation instanceof Annotations\Defaults ) {
                #    $this->defaults->add($file, $annotation, $method, 'method');
                }
            }
        }
        foreach ( $file->getPropertyAnnotations() as $property => $annotations ) {
            if ( count($annotations) === 0 ) {
                continue;
            }
            foreach ( $annotations as $annotation ) {
                if ( $annotation instanceof Annotations\Defaults ) {
                   # $this->defaults()->add($file, $annotation, $property, 'property');
                }
            }
        }
    }

    public function registerAtPath($filePath)
    {
        $file = $this->scanner->scanFile($filePath);
        if ( $file instanceof ClassFileInfo ) {
            $this->register($file);
            return true;
        }
        return false;
    }

    public function registerInPath($path)
    {
        $registered = 0;
        foreach ( $this->scanner->scanDirectory($path) as $info ) {
            $this->register($info);
            $registered++;
        }
        return $registered;
    }


    protected function mergeDefaults($key, $config, $method)
    {
        $config = is_array($config) ? $config : config($config);
        $this->app->booting(function($app) use ($key, $config, $method) {
            $app['codex']->setConfig($key, call_user_func_array($method, [ $app['codex']->config($key), $config ]));
        });
    }

    public function mergeDefaultProjectConfig($config, $method = 'array_replace_recursive')
    {
        $this->mergeDefaults('default_project_config', $config, $method);
    }

    public function mergeDefaultDocumentAttributes($config, $method = 'array_replace_recursive')
    {
        $this->mergeDefaults('default_document_attributes', $config, $method);
    }

    /**
     * @return Filesystem
     */
    public function getFs()
    {
        return $this->fs;
    }



    public static function __callStatic($method, array $parameters = [ ])
    {
        $instance = static::getInstance();
        if ( method_exists($instance, $method) ) {
            return call_user_func_array([ $instance, $method ], $parameters);
        }
        throw new BadMethodCallException("Method $method does not exist in class " . static::class);
    }

    public function __call($method, array $parameters = [ ])
    {
        $collections = [ 'filters', 'themes', 'hooks', 'defaults' ];
        if ( in_array($method, $collections, true) ) {
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
}