<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/11/16
 * Time: 6:20 AM
 */

namespace Codex\Addons\Filters;

use Codex\Addons\Annotations\Filter;
use Codex\Documents\Document;

/**
 * Class HeaderFilter
 * @Filter("header", config="config", after={"parser", "toc"})
 * @package Codex\Addons\Filters
 */
class HeaderFilter
{
    /** @var \Codex\Support\Collection */
    public $config = [
        'view'                 => 'filters.header',
        'remove_from_document' => true,
        'remove_regex'         => '/<h1>(.*?)<\/h1>/',
    ];

    /** @var \Codex\Codex */
    public $codex;

    public function handle(Document $document)
    {
        if ( $this->config[ 'remove_from_document' ] )
        {
            $this->remove($document);
        }
        $html = view($this->codex->view($this->config['view']), $document->getAttributes())->render();
        $document->setContent($html . $document->getContent());
    }

    protected function remove(Document $d)
    {
        if ( $d->attr('title', false) !== false )
        {
            $d->setContent(preg_replace($this->config[ 'remove_regex' ], '', $d->getContent(), 1));
        }
    }

}
