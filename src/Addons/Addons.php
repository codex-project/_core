<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Scanner\ClassFileInfo;
use Codex\Core\Addons\Scanner\Finder;
use Codex\Core\Addons\Scanner\Scanner;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Traits\Macroable;
use Laradic\Support\Filesystem;
use Laradic\Support\Path;
use ReflectionClass;

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

    /** @var \Laradic\Support\Filesystem */
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
     * @param \Laradic\Support\Filesystem                  $fs
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
            $this->resolveFileAnnotation($file);
        }
    }

    protected function resolveFileAnnotation(ClassFileInfo $file)
    {
        $types = [
            'class'    => $file->getClassAnnotations(),
            'method'   => $file->getMethodAnnotations(),
            'property' => $file->getPropertyAnnotations(),
        ];
        foreach ( $types as $type => $annotations ) {
            foreach ( $annotations as $annotation ) {
                $info = [
                    'type'       => $type,
                    'annotation' => $annotation,
                    'class'      => $file->getClassName(),
                    'file'       => $file->getFilename(),
                ];
                switch ( true ) {
                    case $annotation instanceof Annotations\Document:
                        $this->documents[ $file->getClassName() ] = array_merge($info, [
                            'name'       => $annotation->name,
                            'extensions' => $annotation->extensions,
                        ]);
                        break;
                    case $annotation instanceof Annotations\Hook:
                        $this->hooks[ $file->getClassName() ] = array_merge($info, [
                            'name' => $annotation->name,
                        ]);
                        break;
                    case $annotation instanceof Annotations\Filter:
                        $this->filters[ $file->getClassName() ] = array_merge($info, [
                            'name'   => $annotation->name,
                            'for'    => $annotation->for,
                            'config' => [ ],
                        ]);
                        break;
                    case $annotation instanceof Annotations\FilterConfig:
                        $this->filters[ $file->getClassName() ] = array_merge($info, [
                            'name' => $annotation->name,
                            'for'  => $annotation->for,
                        ]);
                        break;
                }
            }
        }
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

}
