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
namespace Codex\Processors\Parser;

interface ParserInterface
{
    /**
     * Transforms the given text into HTML
     *
     * @param string $text
     *
     * @return string The HTML Output
     */
    public function parse($text);

    /**
     * getName method
     * @return string
     */
    public function getName();

    /**
     * setConfig method
     *
     * @param array $config
     *
     * @return void
     */
    public function setConfig(array $config = [ ]);
}