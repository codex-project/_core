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
namespace Codex\Addons\Collections;

use Codex\Addons\Annotations\Processor;
use Codex\Addons\Hydrators\ProcessorHydrator;
use Codex\Documents\Document;
use Codex\Exception\CodexException;
use Codex\Support\Collection;
use Codex\Support\Sorter;
use Codex\Support\Traits\HookableTrait;
use Laradic\AnnotationScanner\Scanner\ClassFileInfo;

/**
 * This is the class FilterAddons.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 */
class ProcessorCollection extends BaseCollection
{
    use HookableTrait;

    const MISSING_THROWS_EXECEPTION = 1;
    const MISSING_IGNORED = 2;

    public static $handleMissing = self::MISSING_IGNORED;

    protected $currentDocument;

    public function add(ClassFileInfo $file, Processor $annotation)
    {
        $class    = $file->getClassName();
        $instance = null; //$this->app->make($class);
        $data     = array_merge(compact('file', 'annotation', 'class', 'instance'), (array)$annotation);
        $processor = $this->app->build(ProcessorHydrator::class);
        $processor->hydrate($data);

        $this->set($annotation->name, $processor);
    }

    public function run($name, Document $document)
    {
        /** @var Processor $annotation */
        $this->currentDocument = $document;
        $project               = $document->getProject();
        $processor             = $this->get($name);

        if($processor->plugin && false === $this->addons->plugins->canRunPlugin($processor->plugin)){
            throw CodexException::because("Cannot run processor [{$name}] belonging to plugin [{$processor->plugin}] because the plugin can not run. Ensure the plugin is installed and enabled");
        }
        // hook point before can prevent the processor from running
        if ( false === $this->hookPoint('addons:processor:before', [ $name ]) )
        {
            return $processor;
        }

        $instance   = $this->getInstance($name);
        $annotation = $processor[ 'annotation' ];

        if ( $annotation->config !== false )
        {
            // get default config
            if ( ! property_exists($instance, $annotation->config) )
            {
                throw CodexException::because('Config not found for ' . $processor[ 'class' ]);
            }
            $config                          = $instance->{$annotation->config};
            $config                          = array_replace_recursive(
                $config,
                $project->config('processors.' . $name, [ ]),
                $document->attr('processors.' . $name, [ ])
            );
            $instance->{$annotation->config} = new Collection($config);
        }
        if ( property_exists($instance, 'codex') )
        {
            $instance->codex = $document->getCodex();
        }
        if ( property_exists($instance, 'project') )
        {
            $instance->project = $document->getProject();
        }
        if ( property_exists($instance, 'document') )
        {
            $instance->document = $document;
        }

        // hook point after can prevent the processor from running
        if ( false === $this->hookPoint('addons:processor:after', [ $name, $annotation, $instance ]) )
        {
            return $processor;
        }

        $this->app->call([ $instance, $annotation->method ], compact('document'));

        return $processor;
    }

    public function get($key, $default = null)
    {
        if ( false === $this->has($key) )
        {
            throw CodexException::processorNotFound(': ' . (string)$key, $this->currentDocument);
        }
        return parent::get($key, $default);
    }

    protected function getInstance($name)
    {
        $processor = $this->get($name);
        if ( $processor[ 'instance' ] === null )
        {
            $processor[ 'instance' ] = $this->app->build($processor[ 'class' ]);
            $this->set($name, $processor);
        }
        return $processor[ 'instance' ];
    }

    public function hasAll($names, $returnHasNot = false)
    {
        if ( is_string($names) )
        {
            $names = func_get_args();
        }
        foreach ( $names as $name )
        {
            if ( false === $this->has($name) )
            {
                return $returnHasNot ? $name : false;
            }
        }
        return true;
    }

    //# GETTERS & SETTERS
    public function getSorted($names)
    {
        $all = $this->whereIn('name', $names)->sortBy('priority')->replaceProcessors();
        $all->each(function ($processor) use ($all)
        {
            /** @var Processor $annotation */
            $annotation = $processor[ 'annotation' ];
            foreach ( $annotation->before as $before )
            {
                $otherProcessor = $all->where('name', $before)->first();
                if ( $otherProcessor !== null && false === in_array($annotation->name, $otherProcessor[ 'after' ], true) )
                {

                    $otherProcessor[ 'after' ][] = $annotation->name;
                    $all->set($before, $otherProcessor);
                }
            }
        });
        $sorter = new Sorter();
        foreach ( $all as $item )
        {
            $sorter->addItem($item[ 'name' ], $item[ 'after' ]);
        }
        $sorted = $sorter->sort();
        if ( count($sorter->getMissing()) > 0 )
        {
            if ( static::$handleMissing === self::MISSING_IGNORED )
            {
            }
            elseif ( static::$handleMissing === self::MISSING_THROWS_EXECEPTION )
            {
                $dep = array_keys($sorter->getMissing());
                $dep = implode(', ', $dep);
                throw CodexException::because("Sorter encountered a missing dependency for {$dep}");
            }
        }
        $sorted = array_merge($sorted, array_diff($names, $sorted));
        return $sorted;
    }

    public function replaceProcessors()
    {
        $items = $this->items;
        foreach ( $items as $name => $item )
        {
            if ( isset($item[ 'replaces' ]) )
            {
                $items[ $name ] = $this->replaceProcessor($items, $name);
            }
        }
        return new static($items);
    }

    protected function replaceProcessor($items = [ ], $name)
    {
        if ( isset($items[ $name ][ 'replaces' ]) )
        {
            $replacement    = $items[ $name ][ 'replaces' ];
            $items[ $name ] = $items[ $replacement ];
            return $this->replaceProcessor($items, $replacement);
        }
        return $items[ $name ];
    }
}
