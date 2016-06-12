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

    /** @var \Codex\Codex */
    public $codex;

    /** @var \Codex\Projects\Project */
    public $project;

    /** @var \Codex\Documents\Document */
    public $document;


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
        $r       = $this->getRenderer();
        $content = $r->render($d->getContent());
        $this->replaceLinks($content);
        $d->setContent($content);
    }

    /**
     * getRenderer method
     * @return Markdown\RendererInterface
     * @throws \ErrorException
     */
    protected function getRenderer()
    {
        // Ensure renderer is bound, otherwise bind the default one
        $binding = Markdown\RendererInterface::class;
        if ( false === app()->bound($binding) )
        {
            app()->bind($binding, $this->config->get('renderer', Markdown\CodexMarkdownRenderer::class));
        }

        // Create the renderer instance
        /** @var Markdown\RendererInterface $renderer */
        $renderer = app()->make($binding);
        if ( !$renderer instanceof $binding )
        {
            throw new \ErrorException("Renderer [{$renderer}] does not implement [{$binding}]");
        }

        // Apply the renderer's config to the renderer
        if ( $this->config->has($renderer->getName()) )
        {
            $renderer->setConfig($this->config->get($renderer->getName(), [ ]));
        }

        return $renderer;
    }

    protected function replaceLinks(&$content)
    {

        #$baseRoute = url(config('codex.routing.base_route'));
        $extensions = array_keys($this->codex->config('extensions'));
        $extensions = collect($extensions)->transform(function ($extension)
        {
            return '\.' . $extension;
        })->implode('|');

        $found = preg_match_all('/href\=\"(.*?)(' . $extensions . ')\"/', $content, $matches);

        if ( $found === 0 )
        {
            return;
        }

        $matches = collect($matches)->transform(function ($match, $key)
        {
            return $key === 2 ? $match : array_unique($match);
        })->toArray();
        foreach ( $matches[ 0 ] as $i => $match )
        {
            $document  = $matches[ 1 ][ $i ];
            $extension = $matches[ 2 ][ $i ];
            $new       = str_replace($document . $extension, $document, $match);
            $content   = str_replace($match, $new, $content);
        }
    }
}