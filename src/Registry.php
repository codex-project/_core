<?php
namespace Codex\Core;

use BadMethodCallException;
use Codex\Core\Support\Collection;

/**
 * This is the class Repository.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method Collection filters(...$params)
 * @method Collection hooks(...$params)
 * @method Collection themes(...$params)
 * @property Collection $filters
 * @property Collection $hooks
 * @property Collection $themes
 *
 */
class Registry
{
    /** @var Registry */
    static protected $instance;

    public static function getInstance()
    {
        if ( static::$instance === null ) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /** @var \Codex\Core\Support\Collection */
    protected $filters;

    /** @var \Codex\Core\Support\Collection */
    protected $themes;

    /** @var \Codex\Core\Support\Collection */
    protected $hooks;


    protected function __construct()
    {
        $this->filters = new Collection();
        $this->themes  = new Collection();
        $this->hooks   = new Collection();
    }

    public static function __callStatic($method, array $parameters = [ ])
    {
        $instance = static::getInstance();
        if ( method_exists($instance, $method) ) {
            return call_user_func_array([ $instance, $method ], $parameters);
        }
        throw new BadMethodCallException("Method $method does not exist in class " . static::class);
    }

    public function __call($method, array $parameters = [ ])
    {
        $collections = [ 'filters', 'themes', 'hooks' ];
        if ( in_array($method, $collections, true) ) {
            $collection = $this->{$method};
            $args       = count($parameters);
            if ( $args === 0 ) {
                return $collection;
            } else {
                $method = array_shift($parameters);
                return call_user_func_array([ $collection, $method ], $parameters);
            }
        }
        throw new BadMethodCallException("Method $method does not exist in class " . get_class($this));
    }
}