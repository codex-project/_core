<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Addon;


class Addons
{
    protected $items;

    public function __construct()
    {
        $this->items = new AddonCollection;
    }
    /**
     * register method
     *
     * @return AddonProvider
     */
    public function register(AddonProvider $addon)
    {
        #$this->items->put() = $addon;
    }

    /**
     * Get addon by slug
     * @param string $slug
     * @return AddonProvider[]
     */
    public function get($slug)
    {
        #return Addon[]
    }

    /**
     * all method
     *
     * @return AddonProvider[]
     */
    public function all()
    {
    }

}
