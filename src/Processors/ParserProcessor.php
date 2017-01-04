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
namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Codex;
use Codex\Documents\Document;
use Codex\Processors\Parser\ParserInterface;
use Codex\Projects\Project;
use Codex\Support\Collection;

/**
 * This is the class ParserFilter.
 *
 * @Processor("parser", priority=0, config="config", after={"attributes"})
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
class ParserProcessor
{
    /** @var Collection */
    public $config = [
        'parser'   => Parser\MarkdownParser::class,
        'markdown' => [
            'renderer' => Parser\Markdown\CodexMarkdownRenderer::class,
        ],
    ];

    /** @var Codex */
    public $codex;

    /** @var Project */
    public $project;

    /** @var Document */
    public $document;


    public function handle(Document $document)
    {
        /** @var ParserInterface $parser */
        $parser       = app()->build($this->config[ 'parser' ]);
        $parserName   = $parser->getName();
        $parserConfig = $this->config->get($parserName, [ ]);
        $parser->setConfig($parserConfig->toArray());
        $document->setContent($parser->parse($document->getContent()));
    }
}
