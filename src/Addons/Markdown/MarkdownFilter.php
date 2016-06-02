<?php
namespace Codex\Addons\Markdown;

use Codex\Addons\Annotations\Filter;
use Codex\Documents\Document;
use Codex\Support\Collection;

/**
 * This is the class MarkdownFilter.
 *
 * @package        Codex\Addon
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @Filter("markdown", config="config")
 */
class MarkdownFilter
{

    /** @var \Codex\Addons\Markdown\Renderers\RendererInterface */
    protected $renderer;

    /** @var Collection */
    public $config = [
        'renderer'  => 'Codex\Addon\Markdown\Renderers\CodexMarkdownRenderer',
        'parsedown' => [
            'fenced_code_lang_class' => 'hljs lang-{LANG}',
        ]
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
     * @return Renderers\RendererInterface
     * @throws \ErrorException
     */
    protected function getRenderer()
    {
        $binding = Renderers\RendererInterface::class;
        app()->bind($binding, $this->config->get('renderer', Renderers\ParsedownRenderer::class));
        /** @var Renderers\RendererInterface $renderer */
        $renderer = app()->make($binding);
        if ( ! $renderer instanceof $binding ) {
            throw new \ErrorException("Renderer [{$renderer}] does not implement [{$binding}]");
        }
        if ( $this->config->has($renderer->getName()) ) {
            $renderer->setConfig($this->config->get($renderer->getName()));
        }
        return $renderer;
    }
}