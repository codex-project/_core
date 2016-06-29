<?php
namespace Codex\Addons;

use Codex\Addons\Scanner\ClassFileInfo;
use Codex\Addons\Scanner\ClassInspector;
use Codex\Addons\Scanner\AnnotationScanner as AnnotationScanner;
use Codex\Support\Collection;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Sebwite\Filesystem\Filesystem;
use Sebwite\Support\Util;
use Symfony\Component\Finder\SplFileInfo;

class Scanner
{
    /** @var \Codex\Support\Collection */
    protected $manifest;

    /** @var \Sebwite\Filesystem\Filesystem */
    protected $fs;

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    /** @var array */
    protected $annotations = [
        Annotations\Hook::class,
        Annotations\Processor::class,
    ];

    protected $addons;

    public function __construct(Factory $addons)
    {
        $this->addons   = $addons;
        $this->manifest = new Collection();
        $this->fs       = new Filesystem();
        $this->reader   = new AnnotationReader();

        foreach ( $this->fs->globule(__DIR__ . '/Annotations/*.php') as $filePath )
        {
            AnnotationRegistry::registerFile($filePath);
        }
    }

    public function getAddonPaths()
    {
        if ( $this->getManifest()->isEmpty() )
        {
            $this->getManifest()->load();
        }
        return $this->getManifest()->get('addons.*.path', [ ]);
    }

    public function getManifestPath()
    {
        return $this->addons->getManifestPath();
    }

    public function getManifest()
    {
        return $this->addons->getManifest();
    }

    public function findAll()
    {
        $files = [ ];
        $paths = $this->getAddonPaths();
        foreach ( $paths as $path )
        {
            $files = array_merge($files, $this->scanDirectory($path));
        }
        return $files;
    }

    public function scanDirectory($path)
    {
        $files = [ ];
        foreach ( $this->createAnnotationScanner($this->annotations)->in($path) as $file )
        {
            $files[] = $file;
        }
        return $files;
    }

    public function scanFile($path)
    {
        $className = Util::getClassNameFromFile($path);
        $file      = new SplFileInfo($path, $path, $path);
        $inspector = new ClassInspector($className, $this->reader);
        return new ClassFileInfo($file, $inspector);
    }

    protected function createAnnotationScanner($annotationClass)
    {
        if ( ! is_array($annotationClass) )
        {
            $annotationClass = [ $annotationClass ];
        }
        $scanner = new AnnotationScanner($this->reader);
        return $scanner->scan($annotationClass);
    }

}
