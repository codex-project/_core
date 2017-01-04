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


namespace Codex {

    /**
     * Class Codex
     *
     * @package Codex
     *
     * @property-read \Codex\Addons\Addons        $addons       The addons instance
     * @property-read \Codex\Dev\Dev              $dev          The dev instance
     * @property-read \Codex\Projects\Projects    $projects     The projects instance
     * @property-read \Codex\Menus\Menus          $menus        The menus instance
     * @property-read \Codex\Addon\Auth\CodexAuth $auth         The auth addon instance
     * @property-read \Codex\Addon\Git\CodexGit   $git          The theme instance
     * @property-read \Codex\Addon\Phpdoc\Phpdoc  $phpdoc       The phpdoc instance
     * @property-read \Codex\Theme                $theme        The theme instance
     *
     */
    class Codex
    {
    }
}

namespace Codex\Projects {

    /**
     * This is the class Project.
     *
     * @package        Codex\Projects
     * @author         CLI
     * @copyright      Copyright (c) 2015, CLI. All rights reserved
     *
     * @property-read \Codex\Addon\Git\GitProject $git          The git project instance
     *
     */
    class Project
    {

    }
}
