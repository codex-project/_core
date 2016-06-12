<?php
namespace Codex\Addons\Filters;

use Codex\Addons\Annotations\Filter;
use Codex\Addons\Filters\Markdown;
use Codex\Documents\Document;
use Codex\Support\Collection;

/**
 * This is the class MarkdownFilter.
 *
 * @package        Codex\Addon
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @Filter("markdown", config="config", after={"attributes"})
 */
class MarkdownFilter
{

    /** @var \Codex\Addons\Filters\Markdown\RendererInterface */
    protected $renderer;

    /** @var Collection */
    public $config = [
        'renderer'  => 'Codex\Addons\Filters\Markdown\CodexMarkdownRenderer',
        'parsedown' => [
            'fenced_code_lang_class' => 'hljs lang-{LANG}',
        ],
        'codex'     => [ ],
        'cebe'      => [ ],
        'php'       => [ ],
    ];


    /**
     * handle method
     *
     * @param \Codex\Documents\Document $document
     *
     * @throws \ErrorException
     */
    public function handle(Document $document)
    {
        $this->render($document);
    }

    protected function render(Document $d)
    {
        $r = $this->getRenderer();
        $d->setContent($r->render($d->getContent()));
    }

    /**
     * getRenderer method
     * @return Markdown\RendererInterface
     * @throws \ErrorException
     */
    protected function getRenderer()
    {
        $binding = Markdown\RendererInterface::class;
        app()->bind($binding, $this->config->get('renderer', Markdown\ParsedownRenderer::class));
        /** @var Markdown\RendererInterface $renderer */
        $renderer = app()->make($binding);
        if ( !$renderer instanceof $binding ) {
            throw new \ErrorException("Renderer [{$renderer}] does not implement [{$binding}]");
        }
        if ( $this->config->has($renderer->getName()) ) {
            $renderer->setConfig($this->config->get($renderer->getName()));
        }
        return $renderer;
    }
}