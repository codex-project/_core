<?php
/**
 * Part of the CLI PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Contracts;

use Codex\Log\Writer;
use Codex\Projects\Project;
use Codex\Support\Collection;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;


/**
 * This is the main Codex factory. It gives access to several sub-components and helper functions.
 *
 * @package        Codex\Core
 * @author         Sebwite
 *
 * @property-read \Codex\Addons\Addons        $addons    The addons instance
 * @property-read \Codex\Projects\Projects    $projects  The projects instance
 * @property-read \Codex\Menus\Menus          $menus     The menus instance
 * @property-read \Codex\Addon\Auth\CodexAuth $auth      The auth addon instance
 * @property-read \Codex\Addon\Git\CodexGit   $git       The theme instance
 * @property-read \Codex\Theme                $theme     The theme instance
 *
 *
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 * @hookPoint      constructed
 *
 */
interface Codex
{
    /**
     * Clear the list of booted models so they will be re-booted.
     *
     * @return void
     */
    public static function clearBooted();

    /**
     * Register a listener for the "booting" event of this class
     *
     * @param string|\Closure $callback
     *
     * @return string The class name
     */
    public static function booting($callback);

    /**
     * Register a listener for the "booted" event of this class
     *
     * @param string|\Closure $callback
     *
     * @return string The class name
     */
    public static function booted($callback);

    /**
     * Creates a error response. To be used in controllers/middleware
     *
     * @param string   $title  The error title
     * @param string   $text   The error text
     * @param int      $code   The HTTP code. 500 Internal Server Error by default
     * @param bool|int $goBack If set to false, it will not display the go back link. If set to a integer value, it will use the integer value as history.back parameter.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function error($title, $text, $code = 500, $goBack = true);

    /**
     * Push a view to a stack
     *
     * @param string     $stackName The name of the stack
     * @param string     $viewName  The namespaced name of the view
     * @param array|null $data      (optional) The view data array
     * @param string     $appendTo  (optional) The view to attach this to
     *
     * @return \Codex\Codex
     */
    public function pushToStack($stackName, $viewName, $data = null, $appendTo = 'codex::layouts.default');

    /**
     * Generate a URL to a project's default page and version.
     *
     * @param  Project|string $project A Project class instance or project name
     * @param  null|string    $ref     The ref to generate the URL for. If not provided it'll use the default ref
     * @param  null|string    $doc     The document to generate the URL for.
     *
     * @return string
     */
    public function url($project = null, $ref = null, $doc = null);

    /**
     * Writes a log message to the codex log file
     *
     * @param string $level   The log level
     * @param string $message The message to log
     * @param array  $context (optional) The context to log
     */
    public function log($level, $message, $context = [ ]);

    /**
     * Returns a Codex view name
     *
     * @param string $name The simple name
     *
     * @return string The namespaced view name
     */
    public function view($name);

    /**
     * The path to the directory where all documentation projects reside
     *
     * @return string
     */
    public function getDocsPath();

    /**
     * Get cache.
     *
     * @return Cache
     */
    public function getCache();

    /**
     * Set cache.
     *
     * @param  \Illuminate\Cache\CacheManager $cache
     *
     * @return \Codex\Codex
     */
    public function setCache($cache);

    /**
     * Get the log instance
     *
     * @return Writer
     */
    public function getLog();

    /**
     * Set the log value
     *
     * @param Writer|mixed $log The log instance to replace
     *
     * @return \Codex\Codex
     */
    public function setLog($log);

    /**
     * toArray method
     * @return array
     */
    public function toArray();

    /**
     * Get a configuration item of the project using dot notation
     *
     * @param null|string $key
     * @param null|mixed  $default
     *
     * @return array|mixed|Collection
     */
    public function config($key = null, $default = null);

    /**
     * Set the config.
     *
     * @param array|Arrayable|string $key The string key to set the value to. Or to set the whole config, you can pass a array or Arrayable without value
     * @param null|mixed             $value
     *
     * @return \Codex\Codex
     *
     */
    public function setConfig($key, $value = null);

    /**
     * get config value
     *
     * @return array
     */
    public function getConfig();

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
     * @return \Codex\Codex
     */
    public function setContainer(Container $container);

    /**
     * Returns all registered extensions for this class
     * @return array The registered extensions for this class
     */
    public function extensions();

    /**
     * This will return the property. It checks if the property name exists and will return it. If it doesn't exist, it will return the property prefixed with _ (underscore)
     *
     * @param string $type The property name
     *
     * @return mixed
     */
    public function getExtenableProperty($type);

    /**
     * Extend the class with a class or method.
     *
     * @param string          $name      The name to register the extension under
     * @param string|\Closure $extension The extension that should be used
     */
    public function extend($name, $extension);

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
     * @return \Codex\Codex
     */
    public function setFiles($files);

    /**
     * Create a Codex Hook
     *
     * @param string          $event    The hook name
     * @param string|\Closure $callback The callback to execute
     * @param int             $priority (optional) The priority
     */
    public static function hook($event, $callback, $priority = 1);

    /**
     * Register an observer with the Model.
     *
     * @param  object|string $class
     * @param  int           $priority
     *
     * @return void
     */
    public static function observe($class, $priority = 0);

    /**
     * Get the observable event names.
     *
     * @return array The event names that can be observed
     */
    public function getObservableEvents();

    /**
     * Remove all of the event listeners for the model.
     */
    public function flushEventListeners();

    /**
     * Set the observable event names.
     *
     * @param  array $observables
     *
     * @return \Codex\Codex
     */
    public function setObservableEvents(array $observables);

    /**
     * Remove an observable event name.
     *
     * @param  array|mixed $observables
     *
     * @return void
     */
    public function removeObservableEvents($observables);
}
