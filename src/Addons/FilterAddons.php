<?php
namespace Codex\Addons;

use Codex\Addons\Annotations\Filter;
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
class FilterAddons extends AbstractAddonCollection
{
    public function add(ClassFileInfo $file, Filter $annotation)
    {
        $class    = $file->getClassName();
        $instance = null; //$this->app->make($class);
        $data     = array_merge(compact('file', 'annotation', 'class', 'instance'), (array) $annotation);

        $this->set($annotation->name, $data);

    }

    public function runFilter($name, Document $document)
    {
        $project = $document->getProject();
        $filter = $this->get($name);
        $instance = $filter['instance'] === null ? $this->app->build($filter['class']) : $filter['instance'];
        /** @var Filter $annotation */
        $annotation = $filter['annotation'];
        $annotation->after;



        if($annotation->config !== false){
            // get default config
            if(!property_exists($instance, $annotation->config)){
                throw CodexException::because('Config not found for ' . $filter['class']);
            }
            $config = $instance->{$annotation->config};
            $config = array_replace_recursive(
                $config,
                $project->config('filters.' . $name, []),
                $document->attr('filters.' . $name, [])
            );
            $instance->{$annotation->config} = new Collection($config);
        }
        if(property_exists($instance, 'codex')){
            $instance->codex = $document->getCodex();
        }
        if(property_exists($instance, 'project')){
            $instance->project = $document->getProject();
        }
        if(property_exists($instance, 'document')){
            $instance->document = $document;
        }
        $this->app->call([$instance, $annotation->method], compact('document'));
    }

    public function getFilter($name)
    {
        $filter = $this->where('name', $name)->first();
        return $filter;
    }

    public function getSorted($names)
    {
        $all = $this->whereIn('name', $names)->sortBy('priority')->replaceFilters();
        $all->each(function($filter) use ($all) {
            /** @var Filter $annotation */
            $annotation = $filter['annotation'];
            foreach($annotation->before as $before){
                $otherFilter = $all->where('name', $before)->first();
                $otherFilter['after'][] = $annotation->name;
                $all->set($before, $otherFilter);
            }
        });
        $sorter = new Sorter();
        foreach($all as $filter){
            /** @var Filter $annotation */
            $annotation = $filter['annotation'];
            $sorter->addItem($annotation->name, $filter['after']);
        }
        $sorted = $sorter->sort();
        return (new static($sorted))->transform(function($filterName){
            return $this->getFilter($filterName);
        })->replaceFilters();
    }

    public function replaceFilters()
    {
        $items = $this->items;
        foreach ( $items as $class => $item ) {
            if ( isset($item[ 'replaced' ]) ) {
                $items[ $class ] = $this->replaceClass($items, $class);
            }
        }
        return new static($items);
    }

    protected function replaceClass($items = [ ], $class)
    {
        if ( isset($items[ $class ][ 'replaced' ]) ) {
            $replacement     = $items[ $class ][ 'replaced' ];
            $items[ $class ] = $items[ $replacement ];
            return $this->replaceClass($items, $replacement);
        }
        return $items[ $class ];
    }
}
