<?php
namespace Codex\Processors\Links;

use Codex\Processors\LinksProcessor;
use PHPHtmlParser\Dom\HtmlNode;

class Link
{
    /** @var \PHPHtmlParser\Dom\HtmlNode */
    protected $node;

    /** @var \Codex\Processors\LinksProcessor */
    private $processor;

    public function __construct(LinksProcessor $processor, HtmlNode $node)
    {
        $this->processor = $processor;
        $this->node      = $node;
    }

    /**
     * make method
     *
     * @param \Codex\Processors\LinksProcessor $processor
     * @param \PHPHtmlParser\Dom\HtmlNode      $node
     *
     * @return Link
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function make(LinksProcessor $processor, HtmlNode $node)
    {
        return app()->build(static::class, compact('processor', 'node'));
    }

    public function value()
    {
        return (string)$this->href();
    }

    public function __toString()
    {
        return $this->value();
    }

    public function getSchema()
    {
        $schema = 'http';

        if ( preg_match_all('/(\w*?):\/\//', $this->href(), $matches) > 0 )
        {
            $schema = (string)$matches[ 1 ][ 0 ];
        }
        return $schema;
    }

    public function href($href = null)
    {
        if ( $href !== null )
        {
            $this->node->setAttribute('href', $href);
        }
        return $this->node->getAttribute('href');
    }

    public function isExternal()
    {
        return preg_match_all('/^(\w*?):\/\/', $this->href()) > 0;
    }

    public function isDocument()
    {
        $extensions = config('codex.document.extensions', [ ]);
        return array_key_exists($this->getExtension(), $extensions);
    }

    public function getExtension()
    {
        return last(explode('.', $this->href()));
    }

    public function isAction()
    {
        $needle = $this->processor->config[ 'needle' ];
        return str_contains($this->href(), "#{$needle}:");
    }

}