<?php
namespace Codex\Addons;

use Codex\Addons\Annotations\Filter;
use Codex\Addons\Scanner\ClassFileInfo;
use Codex\Documents\Document;
use Codex\Exception\CodexException;
use Codex\Support\Collection;

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
        $instance = $this->app->make($class);
        $data     = array_merge(compact('file', 'annotation', 'class', 'instance'), (array) $annotation);

        $this->set($annotation->name, $data);

    }

    public function runFilter($name, Document $document)
    {
        $project = $document->getProject();
        $filter = $this->get($name);
        $instance = $filter['instance'];
        /** @var Filter $annotation */
        $annotation = $filter['annotation'];

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
        $this->app->call([$instance, $annotation->method], compact('document'));
    }

    public function old()
    {


        $this->app->booted(function ($app) use ($file, $annotation, $class, $instance) {
            $defaults = false;

            $childAnnotations = [
                'method'   => $file->getMethodAnnotations(true, Defaults::class),
                'property' => $file->getPropertyAnnotations(true, Defaults::class),
            ];
            foreach ( $childAnnotations as $type => $annotations ) {
                foreach ( $annotations as $name => $an ) {
                    /** @var Defaults $an */
                    if ( $type === 'method' ) {
                        $defaults = $this->app->call([ $instance, $name ]);
                    } elseif ( $type === 'property' && property_exists($instance, $name) ) {
                        $value = $instance->{$name};
                        if ( is_string($value) ) {
                            $defaults = config($value);
                        } else {
                            $defaults = $value;
                        }
                    }
                }
            }

            if ( $defaults !== false && $defaults !== null ) {
                $config = [ ];
                array_set($config, "filters.{$annotation->name}", $defaults);
                $this->addons->mergeDefaultProjectConfig($config);
                $this->set("{$class}.has_config", true);
            }
        });
    }

    public function getFilter($name)
    {
        $filter = $this->where('name', $name)->first();
        return $filter;
    }

    public function getSorted($names)
    {
        return $this->whereIn('name', $names)->sortBy('priority')->replaceFilters();
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