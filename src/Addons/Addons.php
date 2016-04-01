<?php
namespace Codex\Core\Addons;

use Closure;
use Codex\Core\Addons\Scanner\ClassFileInfo;
use Codex\Core\Addons\Scanner\ClassInspector;
use Codex\Core\Addons\Scanner\Finder;
use Codex\Core\Addons\Scanner\Scanner;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Traits\Macroable;
use Sebwite\Support\Filesystem;
use Sebwite\Support\Path;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class Addons
{
    use Macroable;

    /** @var array */
    protected $annotations = [
        AddonType::DOCUMENT => Annotations\Document::class,
        AddonType::HOOK     => Annotations\Hook::class,
        AddonType::FILTER   => Annotations\Filter::class,
        'filter-config'     => Annotations\FilterConfig::class,
    ];

    /** @var \Sebwite\Support\Filesystem */
    protected $fs;

    /** @var \Illuminate\Contracts\Foundation\Application */
    protected $app;

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    protected $addons = [ ];

    protected $filters = [ ];

    protected $hooks = [ ];

    protected $documents = [ ];

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

        foreach ( $fs->globule(__DIR__ . '/Annotations/*.php') as $filePath ) {
            AnnotationRegistry::registerFile($filePath);
        }
    }


    public function add(AddonServiceProvider $provider)
    {
        $path           = (new ReflectionClass($provider))->getFileName();
        $dir            = Path::getDirectory($path);
        $this->addons[] = [
            'provider' => $provider,
            'name'     => $provider->getName(),
            'depends'  => $provider->getDepends(),
            'path'     => $path,
            'dir'      => $dir,
        ];
        $this->scanDirectory($dir);
    }

    public function scanDirectory($path)
    {
        foreach ( $this->scanner()->in($path) as $file ) {
            $this->handleFileAnnotations($file);
        }
    }

    public function scanFile($path)
    {
        $className = static::getClassNameFromFile($path);
        #$reader    = new AnnotationReader();
        $file      = new SplFileInfo($path,$path,$path);
        $inspector = new ClassInspector($className, $this->reader);
        return new ClassFileInfo($file, $inspector);
    }

    public static function getClassNameFromFile($file)
    {
        $fp    = fopen($file, 'r');
        $class = $buffer = '';
        $i     = 0;
        while ( !$class ) {
            if ( feof($fp) ) {
                break;
            }

            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);

            if ( strpos($buffer, '{') === false ) {
                continue;
            }

            for ( ; $i < count($tokens); $i++ ) {
                if ( $tokens[ $i ][ 0 ] === T_CLASS ) {
                    for ( $j = $i + 1; $j < count($tokens); $j++ ) {
                        if ( $tokens[ $j ] === '{' ) {
                            $class = $tokens[ $i + 2 ][ 1 ];
                        }
                    }
                }
            }
        }
        return $class;
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
        if ( $annotation instanceof Annotations\Document ) {
            $this->documents[ $class ] = [
                'class'      => $class,
                'name'       => $annotation->name,
                'extensions' => $annotation->extensions,
            ];
        } elseif ( $annotation instanceof Annotations\Filter ) {
            $this->filters[ $class ] = [
                'class'  => $class,
                'name'   => $annotation->name,
                'for'    => $annotation->for,
                'config' => [ ],
            ];
        } elseif ( $annotation instanceof Annotations\Hook ) {
            $hookName = $annotation->name;
            $hook     = $class;
            if ( !array_key_exists($hookName, $this->hooks) ) {
                $this->hooks[ $hookName ] = [ ];
            }
            $this->hooks[ $hookName ][] = $hook;
            $this->hook($hookName, $hook);
        }
    }

    protected function handleMethodAnnotation($class, $method, $annotation)
    {
        if ( $annotation instanceof Annotations\Hook ) {
            $hookName = $annotation->name;
            $hook     = "{$class}@{$method}";
            if ( !array_key_exists($hookName, $this->hooks) ) {
                $this->hooks[ $hookName ] = [ ];
            }
            $this->hooks[ $hookName ][] = $hook;
            $this->hook($hookName, $hook);
        }
    }

    protected function handlePropertyAnnotation($class, $property, $annotation)
    {
        if ( $annotation instanceof Annotations\FilterConfig ) {
            $filter =& $this->filters[ $class ];
            $filter = array_replace($filter, [ 'config' => app()->make($class)->{$property} ]);
        }
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

    public function getDocuments()
    {
        return collect($this->documents);
    }

    public function getFilters()
    {
        return collect($this->filters);
    }

    public function getHooks()
    {
        return collect($this->hooks);
    }

    public function all()
    {
        return collect($this->addons);
    }
}
