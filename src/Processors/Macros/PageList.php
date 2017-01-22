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
namespace Codex\Processors\Macros;

use Codex\Addons\Annotations as CA;

/**
 * This is the class PageList.
 *
 * @package        Codex\Processors
 * @author         Robin Radic
 * @CA\Macro("pagelist")
 */
class PageList
{
    /** @var \Codex\Documents\Document */
    public $document;

    /** @var \Codex\Projects\Project */
    public $project;

    public function out($isCloser = false, $path, $exclude)
    {

    }
}
