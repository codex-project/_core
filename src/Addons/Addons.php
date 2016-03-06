<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addons;

use Codex\Core\Addons\Scanner\Scanner;
use Codex\Core\Contracts;
use Codex\Core\Support\Collection;
use Codex\Core\Traits;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\Traits\Macroable;
use Laradic\Support\Filesystem;
use Laradic\Support\Path;
use ReflectionClass;

class Addons
{
    use Macroable;

    /** @var array */
    protected static $annotations = [
        AddonType::DOCUMENT => Annotations\Document::class,
        AddonType::FILTER   => Annotations\Filter::class,
        AddonType::HOOK     => Annotations\Hook::class,
    ];

    /** @var AddonServiceProvider[] */
    protected static $providers = [ ];

    /** @var bool */
    protected static $initialised = false;

    /** @var array */
    protected static $addons = [ ];

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected static $reader;

    /**
     * Addons constructor.
     *
     * @param \Codex\Core\Contracts\Codex $codex
     * @param \Laradic\Support\Filesystem $files
     */
    public static function init()
    {
        if ( static::$initialised ) {
            return;
        }

        #static::$providers = collect();
        #static::$addons    = collect();
        static::$reader    = new AnnotationReader();

        foreach ( Filesystem::create()->globule(__DIR__ . '/Annotations/*.php') as $filePath ) {
            AnnotationRegistry::registerFile($filePath);
        }
        static::$initialised = true;
    }

    public static function register($providers)
    {
        static::init();

        /** @var AddonServiceProvider[] $providers */
        if ( !is_array($providers) ) {
            $providers = [ $providers ];
        }

        foreach ( $providers as $provider ) {
            if ( array_key_exists($provider->getName(), static::$providers) ) {
                continue;
            }

            $path                                      = (new ReflectionClass($provider))->getFileName();
            $dir                                       = Path::getDirectory($path);
            $provides                                  = static::scanDirectory($dir);
            static::$providers[ $provider->getName() ] = compact('provider', 'provides');
        }
    }

    protected static function scanDirectory($dir)
    {
        $provides = [ ];
        foreach ( static::$annotations as $type => $annotationClass ) {
            $scanner = (new Scanner(static::$reader))->scan([ $annotationClass ])->in($dir);
            foreach ( $scanner as $file ) {
                /** @var \Codex\Core\Addons\Scanner\ClassFileInfo $file */
                $provide = [
                    'type'        => $type,
                    'class'       => $file->getClassName(),
                    'file'        => $file->getFilename(),
                    'annotations' => Collection::make([
                        'class'      => $file->getClassAnnotations(),
                        'method'     => $file->getMethodAnnotations(),
                        'properties' => $file->getPropertyAnnotations(),
                    ]),
                ];
                if ( !array_key_exists($type, static::$addons) ) {
                    static::$addons[ $type ] = [ ];
                }
                static::$addons[ $type ][] = $provide;
                $provides[]                = $provide;
            }
        }
        return $provides;
    }

    ##
    ## Types
    ##
    public static function get($type)
    {
        return static::$addons[$type];
    }
}
