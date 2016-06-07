<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */

namespace Codex\Contracts\Support;

/**
 * Interface Dependable
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
interface Dependable
{
    /**
     * get dependencies
     *
     * @return array
     */
    public function getDependencies();

    /**
     * get item key/identifier
     *
     * @return string|mixed
     */
    public function getHandle();
}
