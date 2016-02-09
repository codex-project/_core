<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core;


use FilesystemIterator;
use League\Flysystem\Adapter\Local;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class LocalFilesystem extends Local
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
        if($normalized['type'] === 'link'){
            $normalized['type'] = 'dir';
        }
        return $normalized;
    }
    protected function normalizeFileInfo(SplFileInfo $file)
    {
        return $this->mapFileInfo($file);
    }

}
