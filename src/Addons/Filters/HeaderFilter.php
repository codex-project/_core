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
 * @Filter("header", priority=0, config="config", after={"markdown", "toc"})
 * @package Codex\Addons\Filters
 */
class HeaderFilter
{
    /** @var \Codex\Support\Collection */
    public $config = [
        'template'             => '<header><small><!-- subtitle --></small><h1><!-- title --></h1></header>',
        'remove_from_document' => true,
        'remove_regex'         => '/<h1>(.*?)<\/h1>/',
    ];

    public function handle(Document $document)
    {
        if ( $this->config[ 'remove_from_document' ] ) {
            $this->remove($document);
        }
        $html = $this->generate($document->attr('title'), $document->attr('subtitle'));
        $document->setContent($html . $document->getContent());
    }

    protected function generate($title = null, $subtitle = null)
    {
        if ( $title === null ) {
            return '';
        }
        $html = $this->config[ 'template' ];
        $html = str_replace('<!-- title -->', $title, $html);
        if ( $subtitle !== null ) {
            $html = str_replace('<!-- subtitle -->', $subtitle, $html);
        }
        return $html;
    }

    protected function remove(Document $d)
    {
        if ( $d->attr('title', false) !== false ) {
            $d->setContent(preg_replace($this->config[ 'remove_regex' ], '', $d->getContent(), 1));
        }
    }

}
