<?php
namespace Codex\Core\Addons\Filters;


use Codex\Core\Addons\Annotations\Defaults;
use Codex\Core\Addons\Annotations\Filter;
use Codex\Core\Documents\Document;
use Codex\Core\Support\Collection;

/**
 * This is the class ReplaceHeaderFilter.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @Filter("replace_header", priority=100)
 */
class ReplaceHeaderFilter
{
    /**
     * @var Collection
     */
    public $config;

    /**
     * @Defaults()
     * @var array
     */
    public $defaults = [
        'regex' => '/<h1>(.*?)<\/h1>/'
    ];

    public function handle(Document $document)
    {
        $this->replace($document);
    }
    protected function replace(Document $d)
    {
        if($d->attr('title', false) !== false) {
            $d->setContent(preg_replace($this->config->get('regex', $this->defaults[ 'regex' ]), '', $d->getContent(), 1));
        }
    }

}