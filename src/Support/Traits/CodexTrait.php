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
namespace Codex\Support\Traits;

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
     * @var \Codex\Codex
     */
    protected $codex;

    /**
     * getCodex method
     * @return \Codex\Codex
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
