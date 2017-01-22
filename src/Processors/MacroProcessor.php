<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Documents\Document;
use Codex\Processors\Macros\Macro;

/**
 * This is the class DocTagsFilter.
 *
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @Processor("macros", config="config", after={"parser"})
 */
class MacroProcessor
{
    /** @var \Codex\Support\Collection */
    public $config = 'codex.processors.macro';

    /** @var \Codex\Codex */
    public $codex;

    /** @var \Codex\Projects\Project */
    public $project;

    /** @var \Codex\Documents\Document */
    public $document;

    public static $macros = [];

    public function handle(Document $document)
    {
        // @formatter:off
        preg_match_all('/<!--\*codex:(.*?)\*-->/', $content = $document->getContent(), $matches);
        $definitions = $this->getAllMacroDefinitions();

        // foreach found macro
        foreach ($matches[ 0 ] as $i => $raw) {
            $definition = Macro::extractDefinition($matches[1][$i]);
            if (false === array_key_exists($definition, $definitions)) {
                continue;
            }
            $macro          = $this->createMacro($raw, $matches[1][$i]);
            static::$macros[] = $macro;
            $macro->setHandler($definitions[$macro->definition]);
            $macro->run();
        }
        // @formatter:on
    }

    protected function createMacro($raw, $cleaned)
    {
        $macro           = new Macro($raw, $cleaned);
        $macro->codex    = $this->codex;
        $macro->project  = $this->project;
        $macro->document = $this->document;
        return $macro;
    }

    /**
     * This will get the configured macros. It merges (if defined) the global config, project config and document attributes.
     *
     * Project macros will overide global macros with the same name.
     * Document macros will overide project macros with the same name.
     * Other then that, everything will be merged/inherited.
     *
     * @return array The collected macros as id(used for regex) > handler(the class string name with @ method callsign)
     */
    protected function getAllMacroDefinitions()
    {
        $tags = $this->codex->config('processors.macros', []);
        $tags = array_merge($tags, $this->project->config('processors.macros', []));
        return array_merge($tags, $this->document->attr('processors.macros', []));
    }
}
