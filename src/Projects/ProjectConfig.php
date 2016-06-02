<?php
namespace Codex\Core\Projects;

use ArrayAccess;
use Codex\Core\Contracts\Codex;
use Codex\Core\Support\Collection;
use Codex\Core\Traits\CodexTrait;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/**
 * This is the class ProjectConfig.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 * @mixin Collection
 */
class ProjectConfig implements ArrayAccess, Arrayable, JsonSerializable, Jsonable
{
    use CodexTrait;

    /** @var Collection */
    protected $config;

    public function getDescription()
    {
        return $this->config->get('description', '');
    }

    public function getDefaultVersion()
    {
        return $this->config->get('default', '');
    }


    public function getEnabledFilters()
    {
        return $this->config->get('filters.enabled', [ ])->toArray();
    }

    public function getEnabledFilterNames()
    {
        return $this->config->get('filters.enabled', [ ])->toArray();
    }

    public function getFilterConfig($name)
    {
        $config = $this->config->get("filters.{$name}", []);
        if(!$config instanceof Collection){
            $config = new Collection((array) $config);
        }
        return $config;
    }

    public function getEnabledHooks()
    {
        return $this->config->get('hooks.enabled', [ ])->toArray();
    }

    public function getHookConfig($name)
    {
        return $this->config->get("hooks.{$name}", [ ])->toArray();
    }

    /**
     * ProjectConfig constructor.
     *
     * @param \Codex\Core\Codex $codex
     * @param Arrayable|array   $config
     */
    public function __construct(Codex $codex, $config)
    {
        $this->setCodex($codex);
        $this->setConfig($config);
    }

    /**
     * Set the config value
     *
     * @param array $config
     */
    protected function setConfig($config)
    {
        if ( !is_array($config) ) {
            if ( $config instanceof Arrayable ) {
                $config = $config->toArray();
            }
        }

        $this->config = Collection::make($config);
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->config->toArray();
    }

    /**
     * Whether a offset exists
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->config->has($offset);
    }

    /**
     * Offset to retrieve
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->config->get($offset);
    }

    /**
     * Offset to set
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->config->set($offset, $value);
    }

    /**
     * Offset to unset
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->config[ $offset ]);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function __call($name, $arguments = [ ])
    {
        return call_user_func_array([ $this->config, $name ], $arguments);
    }


}