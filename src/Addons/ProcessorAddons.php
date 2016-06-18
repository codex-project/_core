<?php
namespace Codex\Addons;

use Codex\Addons\Annotations\Processor;
use Codex\Addons\Scanner\ClassFileInfo;
use Codex\Documents\Document;
use Codex\Exception\CodexException;
use Codex\Support\Collection;
use Codex\Support\Sorter;

/**
 * This is the class FilterAddons.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 */
class ProcessorAddons extends AbstractAddonCollection
{
    const MISSING_THROWS_EXECEPTION = 1;
    const MISSING_IGNORED = 2;

    public static $handleMissing = self::MISSING_IGNORED;

    public function add(ClassFileInfo $file, Processor $annotation)
    {
        $class    = $file->getClassName();
        $instance = null; //$this->app->make($class);
        $data     = array_merge(compact('file', 'annotation', 'class', 'instance'), (array)$annotation);

        $this->set($annotation->name, $data);
    }

    public function runProcessor($name, Document $document)
    {
        $project  = $document->getProject();
        $processor   = $this->get($name);
        $instance = $processor[ 'instance' ] === null ? $this->app->build($processor[ 'class' ]) : $processor[ 'instance' ];
        /** @var Processor $annotation */
        $annotation = $processor[ 'annotation' ];
        $annotation->after;


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
        $this->app->call([ $instance, $annotation->method ], compact('document'));
    }

    public function getProcessor($name)
    {
        return $this->where('name', $name)->first();
    }

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
            if(static::$handleMissing === self::MISSING_IGNORED){

            } elseif(static::$handleMissing === self::MISSING_THROWS_EXECEPTION)
            {
                $dep = array_keys($sorter->getMissing());
                $dep = implode(', ', $dep);
                throw CodexException::because("Sorter encountered a missing dependency for {$dep}");
            }
        }
        $sorted = array_merge($sorted, array_diff($names, $sorted));
        return (new static($sorted))->transform(function ($processorName)
        {
            return $this->getProcessor($processorName);
        });
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
