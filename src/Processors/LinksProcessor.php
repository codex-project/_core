<?php
namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Codex;
use Codex\Documents\Document;
use Codex\Processors\Links\Action;
use Codex\Projects\Project;
use Codex\Support\Collection;
use League\Uri\Modifiers\Normalize;
use League\Uri\Schemes\Http as Uri;
use PHPHtmlParser\Dom\HtmlNode;
use Sebwite\Support\Str;

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
        'needle'  => 'codex',
        'actions' => [

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
        $content = $document->getContentDom();
        foreach ( $content->find('a') as $node )
        {
            $href = $node->getAttribute('href');
            if ( $this->isAction($href) )
            {
                $this->callAction($node);
            }
            elseif ( $this->isDocument($href) && $this->isRelative($href) )
            {
                // replaces links that reference other documents to the right url
                $node->setAttribute('href', $this->getDocumentUrl($href));
            }
        }
        $document->setContent($content);
    }

    public function normalizeUrl($url)
    {
        $normalizer = new Normalize();
        return (string)$normalizer(Uri::createFromString($url));
    }

    public function getDocumentUrl($href)
    {
        $href = str_replace_last('.' . $this->getExtension($href), '', $href);
        $href = url()->current() . Str::ensureLeft($href, '/');
        return $this->normalizeUrl($href);
    }

    public function isRelative($href)
    {
        return Uri::createFromString($href)->path->isAbsolute() === false;
    }

    public function isDocument($href)
    {
        $extensions = config('codex.document.extensions', [ ]);
        return array_key_exists($this->getExtension($href), $extensions);
    }

    public function getExtension($href)
    {
        return last(explode('.', $href));
    }

    public function isAction($href)
    {
        $url = Uri::createFromString($href);
        return Str::startsWith($url->getFragment(), $this->config[ 'needle' ] . ':', true);
    }

    public function callAction(HtmlNode $node)
    {
        $url    = Uri::createFromString($node->getAttribute('href'));
        $action = new Action($this, $url, $node);
        $params = explode(':', $url->getFragment());


        array_shift($params); // slice away the needle
        $actionName = array_shift($params);
        $action->setParameters($params);
        $actions = $this->getLinkActions();
        if ( array_key_exists($actionName, $actions) )
        {

            $config = $actions[ $actionName ];
            if ( is_string($config) )
            {
                $config = [ 'call' => $config ];
            }
            $action->setConfig($config);
            $action->call();
        }
    }

    public function getLinkActions()
    {
        $definitions = $this->codex->config('processors.links', [ ]);
        $definitions = array_merge($definitions, $this->config[ 'actions' ]);
        return array_merge($definitions, $this->document->attr('processors.links', [ ]));
    }

}