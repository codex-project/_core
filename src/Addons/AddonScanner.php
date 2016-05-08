<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Scanner\ClassFileInfo;
use Codex\Core\Addons\Scanner\ClassInspector;
use Codex\Core\Addons\Scanner\Scanner;
use Codex\Core\Exception\CodexException;
use Codex\Core\Exception\ManifestNotFoundException;
use Codex\Core\Exception\ManifestParseException;
use Codex\Core\Support\Collection;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Sebwite\Filesystem\Filesystem;
use Sebwite\Support\Util;
use Symfony\Component\Finder\SplFileInfo;

class AddonScanner
{
    /** @var \Codex\Core\Support\Collection */
    protected $manifest;

    /** @var string */
    protected $manifestPath;

    /** @var \Sebwite\Filesystem\Filesystem */
    protected $fs;

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    /** @var array */
    protected $annotations = [
        Annotations\Hook::class,
        Annotations\Filter::class,
        Annotations\Theme::class,
        Annotations\Defaults::class,
    ];


    public function __construct()
    {
        $this->manifest     = new Collection();
        $this->manifestPath = config('codex.manifest_path');
        $this->fs           = new Filesystem();
        $this->reader       = new AnnotationReader();

        foreach ( $this->fs->globule(__DIR__ . '/Annotations/*.php') as $filePath ) {
            AnnotationRegistry::registerFile($filePath);
        }

        $this->reloadManifest();
    }

    public function getAddonPaths()
    {
        if ( $this->manifest->isEmpty() ) {
            $this->reloadManifest();
        }
        return $this->manifest->get('paths', [ ]);
    }

    protected function reloadManifest()
    {
        if ( ! $this->fs->exists($this->manifestPath) ) {
            throw CodexException::manifestNotFound($this->manifestPath);
        }
        $raw            = $this->fs->get($this->manifestPath);
        $data = json_decode($raw, true);
        $this->manifest = new Collection($data);
        if ( $this->manifest->isEmpty() ) {
            throw CodexException::manifestParse('empty manifest file');
        }
    }

    public function findAll()
    {
        $files = [ ];
        foreach ( $this->getAddonPaths() as $path ) {
            $files = array_merge($files, $this->scanDirectory($path));
        }
        return $files;
    }


    public function scanDirectory($path)
    {
        $files = [ ];
        foreach ( $this->createAnnotationScanner($this->annotations)->in($path) as $file ) {
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
        if ( ! is_array($annotationClass) ) {
            $annotationClass = [ $annotationClass ];
        }
        $scanner = new Scanner($this->reader);
        return $scanner->scan($annotationClass);
    }

}