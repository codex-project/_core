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

namespace Codex\Filesystem;

use FilesystemIterator;
use League\Flysystem\Adapter\Local as BaseLocal;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * This is the class Local.
 *
 * @package        Codex\Core
 * @author         Robin Radic
 * @copyright      Copyright (c) 2015, Robin Radic. All rights reserved
 */
class Local extends BaseLocal
{
    /**
     * @param string $path
     * @param int    $mode
     *
     * @return RecursiveIteratorIterator
     */
    protected function getRecursiveDirectoryIterator($path, $mode = RecursiveIteratorIterator::SELF_FIRST)
    {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS),
            $mode
        );
    }

    /**
     * @param SplFileInfo $file
     *
     * @return array
     */
    protected function mapFileInfo(SplFileInfo $file)
    {
        $normalized = parent::mapFileInfo($file);
        if ($normalized['type'] === 'link') {
            $normalized['type'] = 'dir';
        }
        return $normalized;
    }
    protected function normalizeFileInfo(SplFileInfo $file)
    {
        return $this->mapFileInfo($file);
    }
}
