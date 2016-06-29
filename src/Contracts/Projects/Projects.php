<?php
/**
 * Part of the CLI PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Contracts\Projects;

use Codex\Contracts\Codex;
use Codex\Traits\CodexTrait;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

interface Projects
{
    /**
     * getCodex method
     * @return \Codex\Codex|\Codex\Contracts\Codex
     */
    public function getCodex();

    /**
     * Set the codex value
     *
     * @param \Codex\Contracts\Codex $codex
     *
     * @return CodexTrait
     */
    public function setCodex(Codex $codex);

    /**
     * Returns the IoC container.
     *
     * @return \Illuminate\Container\Container
     */
    public function getContainer();

    /**
     * Sets the IoC container instance.
     *
     * @param  \Illuminate\Container\Container $container
     *
     * @return $this
     */
    public function setContainer(Container $container);

    /**
     * Returns the event dispatcher.
     *
     * @return \Illuminate\Events\Dispatcher
     */
    public static function getDispatcher();

    /**
     * Sets the event dispatcher instance.
     *
     * @param  \Illuminate\Events\Dispatcher $dispatcher
     *
     * @return $this
     */
    public static function setDispatcher(Dispatcher $dispatcher);

    /**
     * Unset the event dispatcher for models.
     *
     * @return void
     */
    public static function unsetEventDispatcher();

    /**
     * getEventNamespace method
     * @throw RuntimeException
     * @return string
     */
    public static function getEventNamespace();

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
     * Returns the transformed (namespaced) event name for a hook
     *
     * @param string $event The hook name
     *
     * @return string The transformed event name
     */
    public static function getEventName($event);

    /**
     * Create a Codex Hook
     *
     * @param string          $event    The hook name
     * @param string|\Closure $callback The callback to execute
     * @param int             $priority (optional) The priority
     */
    public static function hook($event, $callback, $priority = 1);

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
