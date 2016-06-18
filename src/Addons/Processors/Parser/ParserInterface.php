<?php
namespace Codex\Addons\Processors\Parser;

interface ParserInterface
{
    /**
     * Transforms the given text into HTML
     *
     * @param string $text
     *
     * @return string The HTML Output
     */
    public function parse($text);

    /**
     * getName method
     * @return string
     */
    public function getName();

    /**
     * setConfig method
     *
     * @param array $config
     *
     * @return void
     */
    public function setConfig(array $config = [ ]);
}