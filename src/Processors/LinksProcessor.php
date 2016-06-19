<?php
namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Codex;
use Codex\Documents\Document;
use Codex\Projects\Project;
use Codex\Support\Collection;

/**
 * This is the class LinkerFilter.
 *
 * @Processor("links", config="config", after={"parser"})
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
class LinksProcessor
{
    /** @var Collection */
    public $config = [
        'actions' => [
            // http://whatever.link#codex:confirm(param1, param2)
            'confirm' => 'Codex\Processors\Links\Codex@confirm'
        ]
    ];

    /** @var Codex */
    public $codex;

    /** @var Project */
    public $project;

    /** @var Document */
    public $document;


    public function handle(Document $document)
    {
        $content = $document->getContentDom();
        foreach($content->find('a') as $link)
        {
            $href = $link->getAttribute('href');
            if(str_contains($href, '#codex:')){
                $a = 'a';
            }
            $a = 'a';
        }
        $this->handleRelativeLinks();
        $this->handleActionLinks();
    }

    private function handleRelativeLinks()
    {

    }

    private function handleActionLinks()
    {
    }


}