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

use cebe\markdown\GithubMarkdown;
use Codex\Documents\Document;

/**
 * Cebe/Markdown filter
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class CebeMarkdownRenderer implements RendererInterface
{
    protected $markdown;

    public function __construct(GithubMarkdown $markdown)
    {
        $this->markdown = $markdown;
    }

    /**
     * handle method
     *
     * @param \Codex\Documents\Document $document
     */
    public function handle(Document $document)
    {
        # $this->markdown->setConfig($settings);
        $document->setContent($this->markdown->parse($document->getContent()));
    }

    /**
     * render method
     *
     * @param $string
     *
     * @return mixed
     */
    public function render($string)
    {
        return  $this->markdown->parse($string);
    }

    public function setConfig($config = [ ])
    {
        foreach ($config as $key => $value) {
            if (property_exists($this->markdown, $key)) {
                $this->markdown->{$key} = $value;
            }
        }
    }

    public function getName()
    {
        return 'cebe';
    }
}
