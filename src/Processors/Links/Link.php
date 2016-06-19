<?php
namespace Codex\Processors\Links;

use Illuminate\Support\Fluent;

class Link extends Fluent
{
    public function add($key, $val, $delimiter = ' ')
    {
        $delimiter = $delimiter === false ? '' : $delimiter;
        $delimiter = $delimiter === true ? ' ' : $delimiter;

        if ( false === array_key_exists($key, $this->attributes) )
        {
            $this->attributes[ $key ] = '';
        }

        $this->attributes[ $key ] .= $delimiter . $val;

        return $this;
    }

    public function remove($key, $value, $delimiter = ' ')
    {
        $this->attributes[$key] = preg_replace('/\s' . $value . '\s/', '', $this->attributes[$key]);
        return $this;
    }

    public function __call($method, $parameters)
    {
        if ( $method === 'class' && count($parameters) === 0 )
        {
            $parameters = [ '' ];
        }

        return parent::__call($method, $parameters);
    }
}