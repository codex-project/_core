<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addons;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Laradic\AnnotationScanner\Scanner\ClassFileInfo;
use Laradic\AnnotationScanner\Scanner\ClassInspector;
use Laradic\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * This is the class Resolver.
 *
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
class Resolver
{

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    /** @var \Laradic\AnnotationScanner\Factory */
    protected $scanner;

    /**
     * Resolver constructor.
     *
     * @param \Codex\Addons\Addons   $factory
     * @param \Codex\Addons\Manifest $manifest
     */
    public function __construct()
    {
        $this->fs       = new Filesystem();
        $this->reader   = new AnnotationReader();
        $this->scanner  = new \Laradic\AnnotationScanner\Factory($this->reader, $this->fs);

//        foreach ($this->fs->globule(__DIR__ . '/Annotations/*.php') as $filePath) {
//            $this->scanner->registerAnnotation($filePath);
//        }
        AnnotationRegistry::registerLoader('class_exists');
        
        $this->scanner->addAnnotation([
            Annotations\Plugin::class,
            Annotations\Hook::class,
            Annotations\Processor::class,
        ]);
    }

    /**
     * getClassFileInfo method
     *
     * @param $file
     * @param $class
     *
     * @return \Laradic\AnnotationScanner\Scanner\ClassFileInfo
     */
    public function getClassFileInfo($file, $class)
    {
        $fileInfo = new SplFileInfo($file, $file, $file);
        return new ClassFileInfo($fileInfo, new ClassInspector($class, $this->reader));
    }

    /**
     * Search file for matching addon annotations and automaticly resolve and add them into their collections
     *
     * @param \Laradic\AnnotationScanner\Scanner\ClassFileInfo $classFileInfo
     *
     * @return Resolved[]
     */
    public function resolveAnnotations(ClassFileInfo $classFileInfo)
    {
        $resolved = [];
        foreach ($classFileInfo->getClassAnnotations() as $annotation) {
            if ($annotation instanceof Annotations\Processor) {
                $resolved[] = $this->createResolvedAnnotation(Addons::PROCESSOR, $classFileInfo, $annotation);
            } elseif ($annotation instanceof Annotations\Hook) {
                $resolved[] = $this->createResolvedAnnotation(Addons::HOOK, $classFileInfo, $annotation);
            } elseif ($annotation instanceof Annotations\Plugin) {
                $resolved[] = $this->createResolvedAnnotation(Addons::PLUGIN, $classFileInfo, $annotation);
            }
        }
        foreach ($classFileInfo->getMethodAnnotations(true) as $method => $annotations) {
            foreach ($annotations as $annotation) {
                if ($annotation instanceof Annotations\Hook) {
                    $resolved[] = $this->createResolvedAnnotation(Addons::HOOK, $classFileInfo, $annotation)->setMethod($method);
                }
            }
        }
        foreach ($classFileInfo->getPropertyAnnotations(true) as $property => $annotations) {
            foreach ($annotations as $annotation) {
                $resolved[] = $this->createResolvedAnnotation(Addons::HOOK, $classFileInfo, $annotation)->setProperty($property);
            }
        }
        return $resolved;
    }

    /**
     * Scan a file and resolve annotations
     *
     * @param $filePath
     *
     * @return Resolved[]
     */
    public function scanAndResolveFile($filePath)
    {
        $file = $this->scanner->scanFile($filePath);
        if ($file instanceof ClassFileInfo) {
            return $this->resolveAnnotations($file);
        }
        return [];
    }

    /**
     * scanAndResolveDirectory method
     *
     * @param $path
     *
     * @return Resolved[]
     */
    public function scanAndResolveDirectory($path)
    {
        $resolved = [];
        foreach ($this->scanner->scanDirectory($path) as $info) {
            $resolved = array_merge($resolved, $this->resolveAnnotations($info));
        }
        return $resolved;
    }

    /**
     * createResolvedAnnotation method
     *
     * @param                                                  $type
     * @param \Laradic\AnnotationScanner\Scanner\ClassFileInfo $classFileInfo
     * @param                                                  $annotation
     *
     * @return \Codex\Addons\Resolved
     */
    protected function createResolvedAnnotation($type, ClassFileInfo $classFileInfo, $annotation)
    {
        return new Resolved($type, $classFileInfo, $annotation);
    }

    /**
     * @return \Doctrine\Common\Annotations\AnnotationReader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @return \Laradic\AnnotationScanner\Factory
     */
    public function getScanner()
    {
        return $this->scanner;
    }
}
