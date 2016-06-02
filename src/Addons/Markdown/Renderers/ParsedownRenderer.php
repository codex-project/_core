<?php
namespace Codex\Addons\Markdown\Renderers;

class ParsedownRenderer implements RendererInterface
{
    /** @var \Codex\Addons\Markdown\Renderers\ParsedownExtra  */
    protected $parsedown;

    /**
     * ParsedownRenderer constructor.
     *
     * @param $parsedown
     */
    public function __construct(ParsedownExtra $parsedown)
    {
        $this->parsedown = $parsedown;
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
        return $this->parsedown->parse($string);
    }

    /**
     * @return ParsedownExtra
     */
    public function getParsedown()
    {
        return $this->parsedown;
    }

    /**
     * Set the parsedown value
     *
     * @param ParsedownExtra $parsedown
     */
    public function setParsedown($parsedown)
    {
        $this->parsedown = $parsedown;
    }


    public function setConfig($config = [ ])
    {
        $this->parsedown->setConfig($config);
    }

    public function getName()
    {
        return 'parsedown';
    }
}