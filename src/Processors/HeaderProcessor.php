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

/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/11/16
 * Time: 6:20 AM
 */

namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Documents\Document;

/**
 * Class HeaderFilter
 * @Processor("header", config="config", after={"parser", "toc"})
 * @package Codex\Addons\Filters
 */
class HeaderProcessor
{
    /** @var \Codex\Support\Collection */
    public $config = 'codex.processors.header';

    /** @var \Codex\Codex */
    public $codex;

    public function handle(Document $document)
    {
        if ($this->config[ 'remove_from_document' ]) {
            $this->remove($document);
        }

        $html = view($this->codex->view($this->config['view']), $document->getAttributes())->render();
        $document->setContent($html . $document->getContent());
    }

    protected function remove(Document $d)
    {
        if ($d->attr('title', false) !== false) {
            $d->setContent(preg_replace($this->config[ 'remove_regex' ], '', $d->getContent(), 1));
        }
    }
}
