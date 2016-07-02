<?php
/**
 * Part of the CLI PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
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
     * Mark a project as active
     *
     * @param $project
     *
     */
    public function setActive($project);

    /**
     * Check if a active project has been set
     * @return bool
     */
    public function hasActive();

    /**
     * Gets the active project. Returns null if not set
     * @return \Codex\Projects\Project|null
     */
    public function getActive();

    /**
     * Renders the project picker menu
     * @return string
     */
    public function renderMenu();

    /**
     * Gets a project by name
     *
     * @param string $name The project name
     *
     * @return \Codex\Projects\Project
     */
    public function get($name);

    /**
     * Renders the sidebar menu
     * @return string
     */
    public function renderSidebar();

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
    public function query();
}
