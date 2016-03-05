<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addons;

use Codex\Core\Addons\Scanner\Scanner;
use Codex\Core\Contracts;
use Codex\Core\Traits;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Laradic\Support\Filesystem;
use Laradic\Support\Path;
use ReflectionClass;

class Addons implements
    Contracts\Addons,
    Contracts\Hookable
{
    use
        Traits\HookableTrait,
        Traits\CodexTrait,
        Traits\FilesTrait,
        Traits\ConfigTrait;

    protected $annotations = [
        Annotations\Addon::class,
        Annotations\Document::class,
        Annotations\Extension::class,
        Annotations\Filter::class,
        Annotations\Hook::class,
    ];

    /** @var \Laradic\Support\Collection */
    protected $providers;

    /** @var \Laradic\Support\Collection */
    protected $addons;

    /** @var \Laradic\Support\Collection */
    protected $documents;

    /** @var \Laradic\Support\Collection */
    protected $extensions;

    /** @var \Laradic\Support\Collection */
    protected $filters;

    /** @var \Laradic\Support\Collection */
    protected $hooks;

    /**
     * @var \Doctrine\Common\Annotations\AnnotationReader
     */
    protected $reader;

    /**
     * Addons constructor.
     *
     * @param \Codex\Core\Contracts\Codex $codex
     * @param \Laradic\Support\Filesystem $files
     */
    public function __construct(Contracts\Codex $codex, Filesystem $files)
    {
        $this->setCodex($codex);
        $this->setFiles($files);

        $this->providers  = collection();
        $this->addons     = collection();
        $this->documents  = collection();
        $this->extensions = collection();
        $this->filters    = collection();
        $this->hooks      = collection();


        //$this->hookPoint('addons:construct');

        $this->reader = new AnnotationReader();

        foreach ( Filesystem::create()->globule(__DIR__ . '/Annotations/*.php') as $filePath ) {
            AnnotationRegistry::registerFile($filePath);
        }

        $found = $this->resolve();

        $this->hookPoint('addons:constructed');
    }

    /**
     * @return \Laradic\Support\Collection
     */
    public function providers()
    {
        return $this->providers;
    }

    /**
     * @return \Laradic\Support\Collection
     */
    public function addons()
    {
        return $this->addons;
    }

    /**
     * @return \Laradic\Support\Collection
     */
    public function documents()
    {
        return $this->documents;
    }

    /**
     * @return \Laradic\Support\Collection
     */
    public function extensions()
    {
        return $this->extensions;
    }

    /**
     * @return \Laradic\Support\Collection
     */
    public function filters()
    {
        return $this->filters;
    }

    /**
     * @return \Laradic\Support\Collection
     */
    public function hooks()
    {
        return $this->hooks;
    }


    public function resolve()
    {
        $found = collect();

        foreach ( $this->providers as $name => $provider ) {
            $path    = (new ReflectionClass($provider))->getFileName();
            $dir     = Path::getDirectory($path);
            $scanner = (new Scanner($this->reader))->scan($this->annotations)->in($dir);

            foreach ( $scanner as $file ) {
                /** @var \Codex\Core\Addons\Scanner\ClassFileInfo $file */
                $found->prepend([
                    'class'       => $file->getClassName(),
                    'file'        => $file->getFilename(),
                    'annotations' => [
                        'class'      => $file->getClassAnnotations(),
                        'method'     => $file->getMethodAnnotations(),
                        'properties' => $file->getPropertyAnnotations(),
                    ],
                ]);
            }
        }

        return $found;
    }


}
