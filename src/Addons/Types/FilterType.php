<?php
namespace Codex\Core\Addons\Types;

use Codex\Core\Documents\Document;

class FilterType extends BaseType
{
    protected $for = [ ];

    protected $config;

    /**
     * FilterType constructor.
     *
     * @param $name
     * @param $class
     * @param $for
     * @param $config
     */
    public function __construct($name, $class, $for, array $config = [ ])
    {
        parent::__construct($name, $class);
        $this->for    = $for = is_array($for) ? $for : [ $for ];
        $this->config = $config;
    }


    public function getType()
    {
        return self::FILTER;
    }

    public function getConfig()
    {
        return $this->get();
    }

    public function get($key = null, $default = null)
    {
        return $key === null ? $this->config : data_get($this->config, $key, $default);
    }

    public function merge(array $config, $method = 'array_replace_recursive')
    {
        $this->config = call_user_func($method, $this->config, $config);
        return $this;
    }

    public function set($key, $value)
    {
        data_set($this->config, $key, $value);
        return $this;
    }

    public function isFor($name)
    {
        return in_array($name, $this->for, true);
    }

    public function getFor()
    {
        return $this->for;
    }

    public function run(Document $document)
    {
        $filter = app()->build($this->class);
        if ( property_exists($filter, 'type') ) {
            $filter->type = $this;
        }
        $this->merge($document->getProject()->getConfig()->getFilterConfig($this->name));
        return app()->call([$filter, 'handle'], compact('document'));
    }
}