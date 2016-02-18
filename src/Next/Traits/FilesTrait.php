<?php
/**
 * Part of the Docit PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Next\Traits;

/**
 * This is the class ConfigTrait.
 *
 * @package        Codex\Core
 * @author         Docit
 * @copyright      Copyright (c) 2015, Docit. All rights reserved
 */
trait FilesTrait
{
    protected $files;

    /**
     * Get all files for the given project.
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * setFiles method
     *
     * @param $files
     *
     * @return $this
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }
}
