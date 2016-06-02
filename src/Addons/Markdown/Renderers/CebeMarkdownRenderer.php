<?php
namespace Codex\Addons\Markdown\Renderers;

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
        foreach($config as $key => $value) {
            $this->markdown->{$key} = $value;
        }
    }

    public function getName()
    {
        return 'cebe';
    }
}
