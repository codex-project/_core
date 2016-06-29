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
namespace Codex\Helpers;

use Codex\Contracts\Codex as CodexContract;
use Codex\Support\Extendable;

class CacheHelper extends Extendable
{
    /**
     * Theme constructor.
     *
     * @param \Codex\Contracts\Codex|\Codex\Codex $parent
     */
    public function __construct(CodexContract $parent)
    {
        $this->setCodex($parent);
    }


}