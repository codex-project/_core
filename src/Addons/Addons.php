<?php
namespace Codex\Core\Addons;

use Closure;
use Codex\Core\Addons\Scanner\ClassFileInfo;
use Codex\Core\Addons\Scanner\ClassInspector;
use Codex\Core\Addons\Scanner\Finder;
use Codex\Core\Addons\Scanner\Scanner;
use Codex\Core\Addons\Types\FilterData;
use Codex\Core\Documents\Document;
use Codex\Core\Menus\Menu;
use Codex\Core\Menus\Menus;
use Codex\Core\Support\Collection;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Traits\Macroable;
use ReflectionClass;
use Sebwite\Filesystem\Filesystem;
use Sebwite\Support\Path;
use Sebwite\Support\Util;
use Symfony\Component\Finder\SplFileInfo;


/**
 * This is the class Addons.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method Collection|mixed documents(...$params)
 * @method Collection|mixed filters(...$params)
 * @method Collection|mixed hooks(...$params)
 * @method Collection|mixed providers(...$params)
 * @method Collection|mixed configs(...$params)
 * @method Collection|mixed themes(...$params)
 */
class Addons
{
    use Macroable;
    const HOOK = 'hook';
    const THEME = 'theme';
    const FILTER = 'filter';

    /** @var array */
    protected $annotations = [
        self::HOOK   => Annotations\Hook::class,
        self::FILTER => Annotations\Filter::class,
        self::THEME  => Annotations\Theme::class,
    ];

    /** @var \Sebwite\Filesystem\Filesystem */
    protected $fs;

    /** @var \Illuminate\Contracts\Foundation\Application */
    protected $app;

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    protected $items = [ ];

    protected $types = [ ];

    /**
     * Adds constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Sebwite\Support\Filesystem                  $fs
     */
    public function __construct(Application $app, Filesystem $fs)
    {
        $this->app    = $app;
        $this->fs     = $fs;
        $this->reader = new AnnotationReader();
        $this->types  = [ 'documents', 'filters', 'hooks', 'providers', 'configs', 'themes' ];

        foreach ( $this->types as $type ) {
            $this->items[ $type ] = new Collection();
        }

        foreach ( $fs->globule(__DIR__ . '/Annotations/*.php') as $filePath ) {
            AnnotationRegistry::registerFile($filePath);
        }

        $this->scanDirectory(path_join(__DIR__, 'Filters'));
        $this->addThemeHook();
    }


    public function add(AddonServiceProvider $provider)
    {
        $path = (new ReflectionClass($provider))->getFileName();
        $dir  = Path::getDirectory($path);
        $this->providers()->add([
            'provider' => $provider,
            'name'     => $provider->getName(),
            'depends'  => $provider->getDepends(),
            'path'     => $path,
            'dir'      => $dir,
            'enabled'  => $provider->isEnabled(),
        ]);
        if ( $provider->isEnabled() ) {
            $this->scanDirectory($dir);
        }
    }

    public function scanDirectory($path)
    {
        foreach ( $this->scanner()->in($path) as $file ) {
            $this->handleFileAnnotations($file);
        }
    }

    public function scanFile($path)
    {
        $className = Util::getClassNameFromFile($path);
        #$reader    = new AnnotationReader();
        $file      = new SplFileInfo($path, $path, $path);
        $inspector = new ClassInspector($className, $this->reader);
        return new ClassFileInfo($file, $inspector);
    }

    protected function getType($annotation)
    {
        foreach($this->annotations as $type => $class){
            if($annotation === $class){
                return $type;
            }
        }
        return false;
    }

    protected function handleFileAnnotations(ClassFileInfo $file)
    {
        $class    = $file->getClassName();
        $data = compact('class', 'file');
        foreach ( $file->getClassAnnotations() as $annotation ) {
            $data = array_merge($data, (array) $annotation);
            if ( $annotation instanceof Annotations\Filter ) {
                $this->filters()->set($class, $data);
            } elseif ( $annotation instanceof Annotations\Hook ) {
                $data['listener'] = $class;
                $this->hooks()->add($data);
                $this->hook($data['name'], $data['listener']);
            } elseif ($annotation instanceof Annotations\Theme){
                $this->themes()->set($data['name'], $data);
            }
        }
        foreach ( $file->getMethodAnnotations() as $method => $annotations ) {
            if ( count($annotations) === 0 ) {
                continue;
            }
            foreach ( $annotations as $annotation ) {
                if ( $annotation instanceof Annotations\Hook ) {
                    $listener = "{$class}@{$method}";
                    $data = array_merge($data, compact('listener', 'method'), (array)$annotation);
                    $this->hooks()->add($data);
                    $this->hook($data['name'], $data['listener']);
                }
            }
        }
        return;
        foreach ( $file->getPropertyAnnotations() as $property => $annotations ) {
            if ( count($annotations) === 0 ) {
                continue;
            }
            foreach ( $annotations as $annotation ) {

            }
        }
    }

    protected function addThemeHook()
    {
        $this->hook('menus:add', function (Menus $menus, $id, Menu $menu) {
            $name = $menus->getCodex()->config('theme', 'default');
            $view = $this->themes('get', "{$name}.menus.{$id}", null);
            if ( $view ) {
                $menu->setView($view);
            }
        });


        app()->booted(function ($app) {
            $name  = codex()->config('theme', 'default');
            $views = [ 'layout', 'view' ];
            foreach ( $views as $view ) {
                $viewFile = $this->themes("get", "{$name}.{$view}", null);
                if ( $view ) {
                    codex()->mergeDefaultDocumentAttributes([ $view => $viewFile ]);
                }
            }
        });
    }

    public function registerTheme($name, array $views = [ ])
    {
        $this->themes()->set($name, $views);
        return $this;
    }

    /**
     * hook method
     *
     * @param string         $name
     * @param string|Closure $hook
     *
     * @return Addons
     */
    public function hook($name, $hook)
    {
        $this->app[ 'events' ]->listen("codex:{$name}", $hook);
        return $this;
    }

    protected function scanner($annotationClass = null)
    {
        if ( $annotationClass === null ) {
            $annotationClass = array_values($this->annotations);
        }
        if ( ! is_array($annotationClass) ) {
            $annotationClass = [ $annotationClass ];
        }
        $scanner = new Scanner($this->reader);
        return $scanner->scan($annotationClass);
    }

    protected function find($type = null)
    {
        $finder = new Finder();
        $finder->setReader($this->reader);
        if ( $type !== null ) {
            return $finder->containsAtLeastOneOf($this->annotations[ $type ]);
        }
        foreach ( $this->annotations as $type => $annotation ) {
            $finder->containsAtLeastOneOf($annotation);
        }
        return $finder;
    }


    public function __call($name, $params = [ ])
    {
        if ( in_array($name, $this->types, true) ) {
            $item    = $this->items[ $name ];
            $iparams = count($params);
            if ( $iparams === 0 ) {
                return $item;
            }
            if ( $iparams === 1 ) {
                return $item[ $params[ 0 ] ];
            }
            if ( $iparams > 1 ) {
                $method = array_shift($params);
                return call_user_func_array([ $item, $method ], $params);
            }
        }
    }


}
