<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */

/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 7/3/16
 * Time: 7:18 PM
 */

namespace Codex\Helpers\Theme;


use ArrayAccess;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Support\Sorter;
use Illuminate\Contracts\Support\Arrayable;
use Laradic\Support\Arr;

abstract class AbstractThemeHelper extends Extendable implements Arrayable, ArrayAccess
{
    /** @var Collection */
    protected $items;

    /**
     * AbstractThemeHelper constructor.
     */
    public function __construct()
    {
        $this->reset();
        $this->bootIfNotBooted();
    }


    public function get($name, $default = null)
    {
        return Arr::get($this->items, $name, $default);
    }

    abstract public function render();


    /**
     * Empties the assets. Removes all javascripts and stylesheets.
     *
     * @return ThemeHelper
     */
    public function reset()
    {
        $this->items = new Collection;

        return $this;
    }

    public function sorted()
    {
        return $this->sorter($this->items);
    }

    /**
     * sortAssets method
     *
     * @param array|Collection $all
     *
     * @return \Codex\Support\Collection
     */
    protected function sorter($all = [ ])
    {
        /** @var Collection $all */
        $all    = $all instanceof Collection ? $all : new Collection($all);
        $sorter = new Sorter;
        $sorted = new Collection;
        foreach ( $all as $name => $asset )
        {
            $sorter->addItem($asset[ 'name' ], $asset[ 'depends' ]);
        }

        foreach ( $sorter->sort() as $name )
        {
            $sorted->add($all->where('name', $name)->first());
        }

        return $sorted;
    }

    public function toArray()
    {
        return $this->items->toArray();
    }

    /**
     * Whether a offset exists
     *
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
     *
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
        return $this->get($offset);
    }

    /**
     * Offset to set
     *
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
     *
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
    }
}
