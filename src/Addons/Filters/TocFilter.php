<?php
namespace Codex\Addons\Filters;

use Codex\Addons\Annotations\Filter;
use Codex\Addons\Filters\Toc\Header;
use Codex\Documents\Document;
use Codex\Support\Collection;
use Illuminate\Contracts\View\Factory;

/**
 * This is the class TocFilter.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @Filter("toc", priority=50, config="config")
 */
class TocFilter
{
    /** @var \Codex\Codex */
    public $codex;

    /** @var Collection|array */
    public $config = [
        'disable'           => [ 1 ],
        'regex'             => '/<h(\d)>([\w\W]*?)<\/h\d>/',
        'list_class' => 'toc',
        'header_link_class' => 'toc-header-link',
        'header_link_show'  => false,
        'header_link_text'  => '#',
        'view'              => 'codex::filters.toc',
    ];

    /** @var \Illuminate\Contracts\View\Factory */
    protected $view;

    protected $slugs = [ ];

    /**
     * TocFilter constructor.
     *
     * @param $view
     */
    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    public function handle(Document $document)
    {
        $content         = $document->getContent();
        $total           = preg_match_all($this->config[ 'regex' ], $content, $matches);
//         create root
//         for each header
//         create node
//         if header nr is same as previous, assign to same parent as previous
//         if header nr is lower then previous, check parent header nr, if header nr lower then parent nr, check parent, etc
//         if header nr is higher then previous, assign as previous child

        // Generate TOC Tree from HTML
        $prevSize = 0;
        $prevNode = $rootNode = $this->createHeaderNode(0, 'root');
        for ( $h = 0; $h < $total; $h++ ) {
            $original = $matches[ 0 ][ $h ];
            $size     = (int)$matches[ 1 ][ $h ];
            $text     = $matches[ 2 ][ $h ];
            if(in_array($size, $this->config['disable'], true)){
                continue;
            }
            $node = $this->createHeaderNode($size, $text);
            if ( $size === $prevSize ) {
                $prevNode->getParent()->addChild($node);
                $node->setParent($prevNode->getParent());
            } elseif ( $size < $prevSize ) {
                $parentNode = $prevNode->getParent();
                while ( true ) {
                    if ( $size === $parentNode->getValue()->getSize() ) {
                        $parentNode->getParent()->addChild($node);
                        $node->setParent($parentNode->getParent());
                        break;
                    }
                    if ( $parentNode === $rootNode ) {
                        break;
                    }
                    $parentNode = $parentNode->getParent();
                }
            } elseif ( $size > $prevSize ) {
                $prevNode->addChild($node);
                $node->setParent($prevNode);
            }

            $node->getValue()->setSlug(
                $slug = $this->makeSlug($text)
            );

            $link = '';
            if ( $this->config[ 'header_link_show' ] === true ) {
                $link = "<p><a name=\"{$slug}\" class=\"{$this->config['header_link_class']}\"></a></p>";
            }
            $replacement = "{$link}<h{$size}>{$text}</h{$size}>";
            $content     = str_replace($original, $replacement, $content);

            $prevSize = $size;
            $prevNode = $node;
        }

        $toc = $this->view
            ->make($this->config[ 'view' ], $this->config)
            ->with('items', $rootNode->getChildren())
            ->render();

        $this->addScript();
        $document->setContent("<ul class=\"{$this->config['list_class']}\">{$toc}</ul>".$content);
    }

    protected function createHeaderNode($size, $text)
    {
        return Header::make($size, $text);
    }

    protected function isAllowedHeader($header)
    {
        return isset($this->config[ 'headers' ][ (int)$header ]) && $this->config[ 'headers' ][ (int)$header ] === true;
    }

    protected function makeSlug($text)
    {
        $slug = str_slug($text);
        if ( in_array($slug, $this->slugs, true) ) {
            return $this->makeSlug($text . '_' . str_random(1));
        }
        return $this->slugs[] = $slug;
    }

    protected function addScript()
    {
        $this->codex->theme->addScript('toc', <<<JS
    $(function(){

      $('.docs-wrapper').find('a[name]').each(function () {
        var self = $(this);
        var anchor = $('<a href="#' + this.name + '"/>').addClass(self.attr('class'));
        self.attr('class', '');
        $(this).parent().next('h2, h3, h4, h5, h6').wrapInner(anchor);
      });
    });
JS
        );
    }
}