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
