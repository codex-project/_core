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
namespace Codex\Contracts\Projects;

interface Projects
{
    /**
     * getCodex method
     * @return \Codex\Codex
     */
    public function getCodex();

    /**
     * Returns the IoC container.
     *
     * @return \Illuminate\Container\Container
     */
    public function getContainer();

    /**
     * Get the filesystem instance.
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function getFiles();

    /**
     * Set the filesystem instance
     *
     * @param mixed|string|\Illuminate\Contracts\Filesystem\Filesystem $files The filesystem instance
     *
     * @return $this
     */
    public function setFiles($files);

    /**
     * Gets a project by name
     *
     * @param string $name The project name
     *
     * @return \Codex\Projects\Project
     */
    public function get($name);

    /**
     * Check if the given project exists.
     *
     * @param  string $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * Return all found projects.
     *
     * @return \Codex\Projects\Project[]
     */
    public function all();

    /**
     * Returns all found projects as array
     * @return array
     */
    public function toArray();

    /**
     * Returns the items (projects) Collection instance to provide advanced sorting and filtering
     *
     * @return \Codex\Support\Collection|\Codex\Projects\Project[]
     */
    public function getItems();
}
