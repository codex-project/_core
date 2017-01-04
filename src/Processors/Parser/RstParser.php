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
namespace Codex\Processors\Parser;

class RstParser implements ParserInterface
{

    protected $config = [
        'docbookVisitor' => 'ezcDocumentRstDocbookVisitor',
        'xhtmlVisitor'   => 'ezcDocumentRstXhtmlVisitor',
    ];

    /**
     * Transforms the given text into HTML
     *
     * @param string $text
     *
     * @return string The HTML Output
     */
    public function parse($text)
    {
        $rstDoc = new \ezcDocumentRst($rstOptions = new \ezcDocumentRstOptions($this->config));
        $rstDoc->loadString($text);
        $htmlDoc = $rstDoc->getAsXhtml();
        return $htmlDoc->save();
    }

    /**
     * getName method
     * @return string
     */
    public function getName()
    {
        return 'rst';
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
        $this->config = array_replace_recursive($this->config, $config);
    }
}
