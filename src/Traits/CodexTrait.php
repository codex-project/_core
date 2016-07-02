<?php
/**
 * Part of the Docit PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Traits;

use Codex\Codex;

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
     * @var \Codex\Contracts\Codex|\Codex\Codex
     */
    protected $codex;

    /**
     * getCodex method
     * @return \Codex\Codex|\Codex\Contracts\Codex
     */
    public function getCodex()
    {
        if ( $this->codex === null && app()->bound('codex') )
        {
            $this->setCodex(app('codex'));
        }
        return $this->codex;
    }

    /**
     * Set the codex value
     *
     * @param \Codex\Contracts\Codex $codex
     *
     * @return CodexTrait
     */
    public function setCodex(Codex $codex)
    {
        $this->codex = $codex;

        if ( method_exists($this, 'setContainer') )
        {
            $this->setContainer($codex->getContainer());
        }

        return $this;
    }
}
