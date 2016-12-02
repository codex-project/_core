<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addons;

use Codex\Addons\Annotations\AbstractAnnotation;
use Codex\Support\Collection;
use Laradic\AnnotationScanner\Scanner\ClassFileInfo;

/**
 * This is the class Resolved.
 *
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
class Resolved
{
    /** @var ClassFileInfo */
    protected $classFileInfo;

    /** @var string */
    protected $type;

    /** @var \Codex\Addons\Annotations\AbstractAnnotation */
    protected $annotation;

    /** @var string */
    protected $method;

    /** @var string */
    protected $property;

    /**
     * Resolved constructor.
     *
     * @param                                                  $type
     * @param \Laradic\AnnotationScanner\Scanner\ClassFileInfo $classFileInfo
     * @param                                                  $annotation
     */
    public function __construct($type, ClassFileInfo $classFileInfo, AbstractAnnotation $annotation)
    {
        $this->type          = $type;
        $this->classFileInfo = $classFileInfo;
        $this->annotation    = $annotation;
    }

    /**
     * Check if the resolved is $type
     *
     * @param $type
     *
     * @return bool
     */
    public function is($type)
    {
        return $this->type === $type;
    }

    /**
     * hasMethod method
     * @return bool
     */
    public function hasMethod()
    {
        return $this->method !== null;
    }

    /**
     * hasProperty method
     * @return bool
     */
    public function hasProperty()
    {
        return $this->property !== null;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the method value
     *
     * @param mixed $method
     *
     * @return Resolved
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set the property value
     *
     * @param mixed $property
     *
     * @return Resolved
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return \Laradic\AnnotationScanner\Scanner\ClassFileInfo
     */
    public function getClassFileInfo()
    {
        return $this->classFileInfo;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * getAnnotation method
     * @return \Codex\Addons\Annotations\AbstractAnnotation|mixed
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }




}
