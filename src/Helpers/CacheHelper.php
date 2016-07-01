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

    public function getCachedLastModified($key, $lastModified, \Closure $create)
    {
        /** @var \Illuminate\Contracts\Cache\Repository $cache */
        $cache = $this->getCodex()->getCache();
        $clm   = (int)$cache->get($key . '.lastModified', 0);
        $plm   = (int)$lastModified;
        if ( $clm !== $plm )
        {
            $cache->forever($key, $create());
            $cache->forever($key . '.lastModified', $plm);
        }
        return $cache->get($key);
    }



}