<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Addons\Filters;

use Codex\Addons\Annotations\Filter;
use Codex\Addons\Filters\DocTags\DocTag;
use Codex\Documents\Document;

/**
 * This is the class DocTagsFilter.
 *
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @Filter("doctags", config="config", priority=140, after={"parser"})
 */
class DocTagsFilter
{
    /** @var \Codex\Support\Collection */
    public $config = [

    ];

    /** @var \Codex\Codex */
    public $codex;

    /** @var \Codex\Projects\Project */
    public $project;

    /** @var \Codex\Documents\Document */
    public $document;

    public function handle(Document $document)
    {
        // @formatter:off
        preg_match_all('/<!--\*codex:(.*?)\*-->/', $content = $document->getContent(), $matches);
        // foreach found doctag
        foreach ( $matches[ 0 ] as $i => $raw )
        {
            $dt          = $this->createDocTag($raw, $matches[1][$i]);
            // foreach configured doctags
            foreach ( $this->getAllTags() as $tag => $handler )
            {
                $exp          = preg_quote($tag, '/');
                $exp          = $dt->isClosing() || $dt->hasArguments() === false ? "/{$exp}/" : "/{$exp}\((.*?)\)/";

                // if found doctag matched configured doctag
                if ( preg_match_all($exp, $dt->cleaned, $matched) > 0 )
                {
                    $dt->setTag($tag, $handler);

                    if ( $dt->hasArguments() )
                    {
                        foreach ( $matched[ 1 ] as $args )
                        {
                            foreach ( array_map('trim', explode(',', $args)) as $arg )
                            {
                                $dt->addArgument($arg);
                            }
                        }
                    }
                }
            }
            $dt->run();
        }
        // @formatter:on
    }

    protected function createDocTag($raw, $cleaned)
    {
        $docTag           = new DocTag($raw, $cleaned);
        $docTag->codex    = $this->codex;
        $docTag->project  = $this->project;
        $docTag->document = $this->document;
        return $docTag;
    }

    protected function getAllTags()
    {
        $tags = $this->codex->config('doctags', [ ]);
        $tags = array_merge($tags, $this->project->config('doctags', [ ]));
        return array_merge($tags, $this->document->attr('doctags', [ ]));
    }
}
