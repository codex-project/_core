<?php
/**
 * Part of the CLI PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */

namespace Codex\Traits;


use Codex\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;


trait AttributesTrait
{

    protected $attributes;

    /**
     * Get a attribute using dot notation
     *
     * @param  string    $key
     * @param null|mixed $default
     *
     * @return array|null|mixed|\Codex\Support\Collection
     */
    public function attr($key = null, $default = null)
    {
        return is_null($key) ? new Collection($this->attributes) : array_get($this->attributes, $key, $default);
    }

    /**
     * Get all document attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set all attributes.
     *
     * @param  array|\Illuminate\Contracts\Support\Arrayable $attributes
     *
     * @return $this
     */
    public function setAttributes($attributes)
    {
        if($attributes instanceof Arrayable){
            $attributes = $attributes->toArray();
        }

        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Merge array into attributes
     *
     * @param array|\Illuminate\Contracts\Support\Arrayable $attributes
     *
     * @return $this
     */
    public function mergeAttributes($attributes)
    {
        if($attributes instanceof Arrayable){
            $attributes = $attributes->toArray();
        }
        $this->attributes = array_replace_recursive($this->attributes, $attributes);

        return $this;
    }

    /**
     * setAttribute method
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        data_set($this->attributes, $key, $value);
        return $this;
    }
}