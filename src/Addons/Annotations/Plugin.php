<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addons\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;

final class Plugin
{
    /**
     * The name of the Plugin
     *
     * @var string
     * @Required()
     */
    public $name;

    /**
     * Other plugins this plugin is dependent on
     * @var array
     */
    public $requires = [];
}