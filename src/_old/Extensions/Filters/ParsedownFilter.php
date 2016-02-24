<?php
namespace Codex\Core\Extensions\Filters;

use Codex\Core\Contracts\Filter;
use Codex\Core\Document;
use Codex\Core\Extensions\Parsers\ParsedownExtra;

/**
 * Parsedown filter
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
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
     * @param  \Codex\Core\Document $document
     * @param  array                $config
     *
*@return void
     */
    public function handle(Document $document, array $config)
    {
        $this->parsedown->setConfig($config);
        $document->setContent($this->parsedown->text($document->getContent()));
    }
}
