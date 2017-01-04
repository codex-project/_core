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
namespace Codex\Processors\Parser\Markdown;

use Codex\Support\Collection;

interface RendererInterface
{
    /**
     * render method
     *
     * @param $string
     *
     * @return mixed
     */
    public function render($string);

    /**
     * setConfig method
     *
     * @param array|Collection $config
     *
     * @return mixed
     */
    public function setConfig($config = [ ]);

    public function getName();
}
