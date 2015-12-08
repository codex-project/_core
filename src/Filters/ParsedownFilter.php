<?php
namespace Docit\Core\Filters;

use Docit\Core\Contracts\Filter;
use Docit\Core\Document;
use Docit\Core\Parsers\ParsedownExtra;

/**
 * Parsedown filter
 *
 * @package   Docit\Core
 * @author    Docit Project Dev Team
 * @copyright Copyright (c) 2015, Docit Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class ParsedownFilter implements Filter
{
    protected $parsedown;

    /**
     * Create a new ParsedownFilter instance.
     *
     * @param  ParsedownExtra  $parsedown
     * @return void
     */
    public function __construct(ParsedownExtra $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    /**
     * Handle the filter.
     *
     * @param  \Docit\Core\Document  $document
     * @param  array                  $config
     * @return void
     */
    public function handle(Document $document, array $config)
    {
        $this->parsedown->setConfig($config);
        $document->setContent($this->parsedown->text($document->getContent()));
    }
}
