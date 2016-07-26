<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex;

use ArrayAccess;
use Codex\Support\Extendable;

/**
 * This is the class DocTest.
 *
 * @author    CLI
 * @copyright Copyright (c) 2015, CLI. All rights reserved
 * @example
 * $dt = new DocTest();
 * $dt->set('a', [ 'b' => 'aaa' ]);
 * $a = $dt->get('a');
 */
class DocTest extends Extendable implements ArrayAccess
{
    /**
     * The associative items array
     *
     * @var array
     */
    protected $items;

    /**
     * Set an item to the given key
     *
     * @param string $key The key to set the item for
     * @param array $item The item to set
     * @example
     * $dt->set('a', [ 'b' => 'aaa' ]);
     */
    public function set($key, $item)
    {

    }

    /**
     * Get a item  specified by key
     *
     * @param string $key The key to get the item
     */
    public function get($key)
    {

    }

    /**
     * Delete the item specified by key
     *
     * @param $key
     */
    public function del($key)
    {

    }

    /**
     * Has a item specified by key
     *
     * @param $key
     */
    public function has($key)
    {

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
        // TODO: Implement offsetExists() method.
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
        // TODO: Implement offsetGet() method.
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
        // TODO: Implement offsetSet() method.
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
        // TODO: Implement offsetUnset() method.
}}
