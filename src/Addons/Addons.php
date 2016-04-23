<?php
namespace Codex\Core\Addons;

use Closure;
use Codex\Core\Addons\Scanner\ClassFileInfo;
use Codex\Core\Addons\Scanner\ClassInspector;
use Codex\Core\Addons\Scanner\Finder;
use Codex\Core\Addons\Scanner\Scanner;
use Codex\Core\Addons\Types\DocumentType;
use Codex\Core\Addons\Types\FilterType;
use Codex\Core\Addons\Types\HookType;
use Codex\Core\Addons\Types\Type;
use Codex\Core\Codex;
use Codex\Core\Documents\Document;
use Codex\Core\Http\Controllers\CodexController;
use Codex\Core\Projects\Project;
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

    /** @var array */
    protected $annotations = [
        Type::DOCUMENT => Annotations\Document::class,
        Type::HOOK     => Annotations\Hook::class,
        Type::FILTER   => Annotations\Filter::class,
        Type::THEME    => Annotations\Theme::class,
        Type::CONFIG => Annotations\Config::class
    ];

    /** @var \Sebwite\Support\Filesystem */
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
        $this->types = [ 'documents', 'filters', 'hooks', 'providers', 'configs', 'themes' ];

        foreach ( $this->types as $type ) {
            $this->items[ $type ] = new Collection();
        }

        foreach ( $fs->globule(__DIR__ . '/Annotations/*.php') as $filePath ) {
            AnnotationRegistry::registerFile($filePath);
        }

        $this->addThemeHook();
    }


    public function add(AddonServiceProvider $provider)
    {
        $path           = (new ReflectionClass($provider))->getFileName();
        $dir            = Path::getDirectory($path);
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

    protected function handleFileAnnotations(ClassFileInfo $file)
    {
        $class    = $file->getClassName();
        $fileName = $file->getFilename();

        foreach ( $file->getClassAnnotations() as $annotation ) {
            $this->handleClassAnnotation($class, $annotation);
        }
        foreach ( $file->getMethodAnnotations() as $method => $annotations ) {
            if ( count($annotations) === 0 ) {
                continue;
            }
            foreach ( $annotations as $annotation ) {
                $this->handleMethodAnnotation($class, $method, $annotation);
            }
        }
        foreach ( $file->getPropertyAnnotations() as $property => $annotations ) {
            if ( count($annotations) === 0 ) {
                continue;
            }
            foreach ( $annotations as $annotation ) {
                $this->handlePropertyAnnotation($class, $property, $annotation);
            }
        }
    }

    protected function handleClassAnnotation($class, $annotation)
    {
        $name     = $annotation->name;
        if ( $annotation instanceof Annotations\Document ) {
            $extensions = $annotation->extensions;
            $this->documents()->set($name, compact('name', 'class', 'extensions'));
        } elseif ( $annotation instanceof Annotations\Filter ) {
            $for = $annotation->for;
            $this->filters()->set($class,  compact('name', 'class', 'for'));
        } elseif ( $annotation instanceof Annotations\Hook ) {
            $listener = $class;
            $this->hooks()->add(compact('name', 'class', 'listener'));
            $this->hook($name, $listener);
        }
    }

    protected function handleMethodAnnotation($class, $method, $annotation)
    {
        if ( $annotation instanceof Annotations\Hook ) {
            $name     = $annotation->name;
            $listener = "{$class}@{$method}";
            $this->hooks()->add(compact('name', 'class', 'listener'));
            $this->hook($name, $listener);
        } elseif ( $annotation instanceof Annotations\Config ) {
            $name            = $annotation->name;
            $type            = $annotation->type;
            $this->configs()->add(compact('name', 'type', 'class', 'method'));
        }
    }

    protected function handlePropertyAnnotation($class, $property, $annotation)
    {
        if ( $annotation instanceof Annotations\Config ) {
            $name            = $annotation->name;
            $type            = $annotation->type;
            $this->configs()->add(compact('name', 'type', 'class', 'property'));
        }
    }

    protected function addThemeHook()
    {
        $this->hook('controller:document', function (CodexController $controller, Document $document, Codex $codex, Project $project) {

            $name = config('codex.theme', 'default');
            if ( $this->themes()->has($name) ) {
                $theme = $this->themes()->get($name);
                foreach ( $theme->get('menus', [ ]) as $id => $view ) {
                    $codex->menus->has($id) && $codex->menus->get($id)->setView($view);
                }
                $views = [ 'layout', 'view' ];
                foreach ( $views as $view ) {
                    if ( $theme->has($view) ) {
                        $document->setAttribute($view, $theme->get($view));
                    }
                }
            }
        });
    }

    public function registerTheme($name, array $views = [ ])
    {
        $this->themes()->set($name,$views);
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
        if ( !is_array($annotationClass) ) {
            $annotationClass = [ $annotationClass ];
        }
        $scanner = new Scanner($this->reader);
        return $scanner->scan($annotationClass);
    }

    protected function find(AddonType $type = null)
    {
        $finder = new Finder();
        $finder->setReader($this->reader);
        if ( $type !== null ) {
            return $finder->containsAtLeastOneOf($this->annotations[ $type->getValue() ]);
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

    public function getFilter($name, $for)
    {
        $filter = $this->filters('where', 'name', $name)->whereHas('for', $for)->last();
        $filter = new FilterType($name, $filter['class'], $filter['for']);
        $this->configs('where', 'type', 'filter')->where('name', $name)->each(function($config) use ($filter) {
            if(isset($config['method'])){
                $data = $this->app->call($config['method']);
            } else {
                $data = $this->app->build($config['class'])->{$config['property']};
            }
            $filter->merge($data);
        });
        return $filter;
    }

}
