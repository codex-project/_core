<?php
/**
 * Part of the Docit PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Support\Traits;

/**
 * The FilesTrait provides get/set methods for a Filesystem instance.
 *
 * @package        Codex\Core
 * @author         Docit
 * @copyright      Copyright (c) 2015, Docit. All rights reserved
 */
trait FilesTrait
{
    protected $files;

    /**
     * Get the filesystem instance.
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set the filesystem instance
     *
     * @param mixed|string|\Illuminate\Contracts\Filesystem\Filesystem $files The filesystem instance
     *
     * @return $this
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }
}
