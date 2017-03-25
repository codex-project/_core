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
namespace Codex\Entities;

use PHPHtmlParser\Dom;

/**
 * This is the class ContentDom.
 *
 * @package        Codex\Entities
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method \PHPHtmlParser\Dom\Collection|\PHPHtmlParser\Dom\HtmlNode[] find(string $selector, int $nth = null)
 */
class ContentDom extends Dom
{
    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * set method
     *
     * @param null $content
     *
     * @return ContentDom
     */
    public function set($content = null)
    {
        return $this->loadStr($content, [
            'cleanupInput' => false,
        ]);
    }
}
