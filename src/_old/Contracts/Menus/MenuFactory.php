<?php
/**
 * Part of the Codex PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Contracts\Menus;

/**
 * This is the MenuFactory.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
interface MenuFactory
{

    /**
     * Creates a new menu or returns an existing
     *
     * @param string $id
     *
     * @return \Codex\Core\Menu
     */
    public function add($id);
}
