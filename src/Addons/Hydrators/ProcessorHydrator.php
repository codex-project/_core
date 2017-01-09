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
namespace Codex\Addons\Hydrators;

/**
 * This is the class ProcessorPresenter.
 *
 * @package        Codex\Addons
 * @author         Radic
 * @copyright      Copyright (c) 2015, Radic. All rights reserved
 *
 */
class ProcessorHydrator extends Hydrator
{
    /** @var \Codex\Addons\Annotations\Processor */
    public $annotation;

    public $instance;


    /**
     * @Required
     * @var string
     */
    public $name;

    /**
     * (optional) The property name of the default configuration this filter has. During runtime, this will be replaced with the actual, processed config Collection
     * @var string
     */
    public $config;

    /**
     * If this filter replaces another (like extending), note its name here
     * @var string
     */
    public $replace ;

    /**
     * The method that will be called when running the filter.
     * @var string
     */
    public $method = 'handle';

    /**
     * The processors that should be called before this filter.  Enables dependency sorting.
     * @var array
     */
    public $after = [];

    /**
     * The processors that should be called after this filter.  Enables dependency sorting.
     * @var array
     */
    public $before = [];

    /**
     * A list of processors that are required to run before this processor. If any of these is not enabled or installed, there will be an Exception saying so.
     * @var array
     */
    public $depends = [];

    /**
     * plugin method
     *
     * @var string|bool
     */
    public $plugin = false;



    /**
     * Force processing of cached documents.
     *
     * Cached documents will not be processed again, their content is already modified properly. Unless you force it with setting this property to true.
     *
     * This should only be implemented when the processor also adjusts things outside of the document's content (like adding assets)
     * The processor should make use of $document->hasCachedContent() method to see if content needs to be modified.
     *
     * @var bool
     */
    public $forceCached = false;
}
