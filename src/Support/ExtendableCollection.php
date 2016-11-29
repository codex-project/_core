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
namespace Codex\Support;

class ExtendableCollection extends Extendable
{
    /** @var \Codex\Support\Collection */
    protected $items;

    /**
     * ExtendableCollection constructor.
     */
    public function __construct()
    {
        $this->items = new \Illuminate\Support\Collection();
    }

    /**
     * get method
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this->items->get($name);
    }

    /**
     * has method
     *
     * @param $name
     *
     * @return boolean
     */
    public function has($name)
    {
        return $this->items->has($name);
    }

    /**
     * all method
     * @return array
     */
    public function all()
    {
        return $this->items->all();
    }

    /**
     * Removes a menu
     *
     * @param $id
     *
     * @return static
     */
    public function forget($id)
    {
        unset($this->items[ $id ]);
        return $this;
    }

    /**
     * getItems method
     * @return \Codex\Support\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
