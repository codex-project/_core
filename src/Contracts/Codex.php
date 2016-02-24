<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Contracts;

use Codex\Core\Contracts\Log;
use Herrera\Version\Version;
use Illuminate\Contracts\Cache\Repository as Cache;


/**
 * This is the class Codex.
 *
 * @package        Codex\Core
 * @author Sebwite
 * @copyright Copyright (c) 2015, Sebwite. All rights reserved
 *
 * @property \Codex\Core\Theme\Theme       $theme
 * @property \Codex\Core\Theme\Assets      $assets
 * @property \Codex\Core\Projects\Projects $projects
 * @property \Codex\Core\Menus\Menus       $menus
 *
 */
interface Codex
{
    public static function booting($callback);

    public static function booted($callback);

    public function mergeDefaultProjectConfig($config);

    public function stack($viewName, $data = null, $appendTo = 'codex::layouts.default');

    /**
     * Generate a URL to a project's default page and version.
     *
     * @param  Project|string $project A Project instance or projectName, will auto-resolve
     * @param  null|string    $ref
     * @param  null|string    $doc
     *
     * @return string
     */
    public function url($project = null, $ref = null, $doc = null);

    /**
     * getLaravelVersion method
     * @return Version
     */
    public function getLaravelVersion();

    /**
     * Writes a log message to the codex log file
     *
     * @param       $level
     * @param       $message
     * @param array $context
     */
    public function log($level, $message, $context = [ ]);

    /**
     * Get root directory.
     *
     * @return string
     */
    public function getRootDir();

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
     * @return Factory
     */
    public function setCache($cache);

    /**
     * get log value
     *
     * @return Log
     */
    public function getLog();

    /**
     * Set the log value
     *
     * @param Log $log
     *
     * @return Factory
     */
    public function setLog($log);

    /**
     * Get a configuration item of the project using dot notation
     *
     * @param null|string $key
     * @param null|mixed  $default
     *
     * @return array|mixed
     */
    public function config($key = null, $default = null);

    /**
     * Set the config.
     *
     * @param  array $config
     *
     * @return void
     */
    public function setConfig($key, $value = null);

    /**
     * get config value
     *
     * @return mixed
     */
    public function getConfig();

    public function extend($name, $extension);

    /**
     * Register an observer with the Model.
     *
     * @param  object|string $class
     * @param  int           $priority
     * @return void
     */
    public static function observe($class, $priority = 0);
}
