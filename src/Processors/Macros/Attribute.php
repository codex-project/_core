<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
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
