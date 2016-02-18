<?php
/**
 * Part of the Docit PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace TASDCodex\Core\Traits;

use Codex\Core\Contracts\Codex;

/**
 * This is the class ConfigTrait.
 *
 * @package        Codex\Core
 * @author         Docit
 * @copyright      Copyright (c) 2015, Docit. All rights reserved
 */
trait CodexTrait
{
    /**
     * @var \Codex\Core\Factory
     */
    protected $codex;

    /**
     * get codex value
     *
     * @return \Codex\Core\Contracts\Codex|\Codex\Core\Factory
     */
    public function getCodex()
    {
        return $this->codex;
    }

    /**
     * Set the codex value
     *
     * @param \Codex\Core\Contracts\Codex $codex
     *
     * @return CodexTrait
     */
    public function setCodex(Codex $codex)
    {
        $this->codex = $codex;

        return $this;
    }
}
