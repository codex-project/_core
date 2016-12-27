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
namespace Codex\Processors\Macros;

/**
 * This is the class Attribute.
 *
 * @package        Codex\Processors
 * @author         Robin Radic
 */
class Attribute
{
    /** @var \Codex\Documents\Document */
    public $document;

    /** @var \Codex\Projects\Project */
    public $project;

    public function printValue($isCloser = false, $key, $default = null)
    {
        return $this->document->attr($key, $default);
    }
}
