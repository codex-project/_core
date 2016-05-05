<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Annotations\Defaults;
use Codex\Core\Addons\Annotations\Filter;
use Codex\Core\Addons\Scanner\ClassFileInfo;

class FilterAddons extends AbstractAddonCollection
{
    public function add(ClassFileInfo $file, Filter $annotation)
    {
        $class    = $file->getClassName();
        $instance = $this->app->build($class);
        $data     = array_merge(
            compact('file', 'annotation', 'class', 'instance'),
            (array)$annotation,
            [ 'has_config' => false ]
        );

        $this->set($class, $data);

        // could be that it should be added later
        if ( $annotation->replace !== false ) {
            $this->set("{$annotation->replace}.replaced", $class);
        }

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