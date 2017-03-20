<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addons\Annotations;

/**
 * This is the class Link.
 *
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 * @Annotation
 */
final class Link extends AbstractProcessorAnnotation
{
    /**
     * @Required()
     * @var string
     */
    public $name;
    /**
     * Parameter names
     * @var array
     */
    public $params = [];

    /**
     * @var array
     */
    public $modifiers = [];
}
