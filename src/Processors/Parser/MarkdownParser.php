<?php
namespace Codex\Processors\Parser;

use Codex\Processors\Parser\Markdown\RendererInterface;

class MarkdownParser implements ParserInterface
{
    /** @var RendererInterface */
    protected $renderer;

    /**
     * Transforms the given text into HTML
     *
     * @param string $text
     *
     * @return string The HTML Output
     */
    public function parse($text)
    {
        return $this->renderer->render($text);
    }

    /**
     * getName method
     * @return string
     */
    public function getName()
    {
        return 'markdown';
    }

    /**
     * setConfig method
     *
     * @param array $config
     *
     * @return void
     */
    public function setConfig(array $config = [ ])
    {
        $this->renderer = app($config['renderer']);
        $this->renderer->setConfig($config);
    }
}