<?php
namespace Codex\Documents;

use PHPHtmlParser\Dom;


/**
 * This is the class ContentDom.
 *
 * @package        Codex\Documents
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