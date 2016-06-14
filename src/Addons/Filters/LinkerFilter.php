<?php
namespace Codex\Addons\Filters;

use Codex\Addons\Annotations\Filter;
use Codex\Codex;
use Codex\Documents\Document;
use Codex\Projects\Project;
use Codex\Support\Collection;

/**
 * This is the class LinkerFilter.
 *
 * @Filter("linker", config="config", after={"parser"})
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
class LinkerFilter
{
    /** @var Collection */
    public $config = [];

    /** @var Codex */
    public $codex;

    /** @var Project */
    public $project;

    /** @var Document */
    public $document;


    public function handle(Document $document)
    {

    }


}