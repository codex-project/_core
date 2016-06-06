<?php
namespace Codex\Dev\Debugbar;

use ArrayAccess;
use Codex\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;

class Debugbar implements Arrayable, ArrayAccess
{
    /**
     * @var \Codex\Core\Support\Collection|Item[]
     */
    protected $items;

    /**
     * Dev constructor.
     *
     * @param $items
     */
    public function __construct()
    {
        $this->items = new Collection();
    }

    public function add($id, $name)
    {
        $this->items->set($id, $item = new Item($this, $id, $name));
        return $item;
    }

    public function get($id)
    {
        return $this->items->get($id);
    }

    public function all()
    {
        return $this->items->all();
    }

    public function toArray()
    {
        return $this->items->values()->toArray();
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
        return $this->items->has($offset);
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
        return $this->items->get($offset);
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
        $this->items->set($offset, $value);
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
        $this->items->forget($offset);
}}