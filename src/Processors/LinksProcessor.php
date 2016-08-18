<?php
namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Codex;
use Codex\Documents\Document;
use Codex\Processors\Links\Action;
use Codex\Projects\Project;
use Codex\Support\Collection;
use FluentDOM\Element;
use InvalidArgumentException;
use League\Uri\Modifiers\Normalize;
use League\Uri\Schemes\Http as Uri;
use Laradic\Support\Str;

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
        'links' => [

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
        $d = $document->getDom();
        $d->find('//a')->each(function (Element $element)
        {
            $url = $element->getAttribute('href');

            try
            {
                if ( $this->isAction($url) )
                {
                    $this->callAction($element);
                }
                elseif ( $this->isDocument($url) && $this->isRelative($url) )
                {
                    // replaces links that reference other documents to the right url
                    $element->setAttribute('href', $this->getDocumentUrl($url));
                }
            }
            catch (InvalidArgumentException $e)
            {
                $this->codex->log('debug', static::class . " throws exception: {$e->getMessage()} | file: {$e->getFile()} | line: {$e->getLine()} | trace: {$e->getTraceAsString()}");
            }
        });
        $document->setDom($d);
    }

    public function normalizeUrl($url)
    {
        $normalizer = new Normalize();

        return (string)$normalizer(Uri::createFromString($url));
    }

    public function isInvalidUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) === false;
    }

    public function getDocumentUrl($url)
    {
        // because the URL also includes the current page as segment, it means we have to go 1 higher. Example:
        // document: "codex/master/getting-started/configure"
        // has link: "../index"
        // normalizes to: "codex/master/getting-started/index"
        // this will fix that
        $url = "../{$url}";
        // endfix


        $url = str_replace_last('.' . $this->getExtension($url), '', $url);
        $url = url()->current() . Str::ensureLeft($url, '/');

        return $this->normalizeUrl($url);
    }

    public function isRelative($url)
    {
        return Uri::createFromString($url)->path->isAbsolute() === false;
    }

    public function isDocument($url)
    {
        $extensions = config('codex.document.extensions', [ ]);

        return array_key_exists($this->getExtension($url), $extensions);
    }

    public function getExtension($url)
    {
        return last(explode('.', $url));
    }

    public function isAction($url)
    {
        return Str::startsWith(Uri::createFromString($url)->getFragment(), $this->config[ 'needle' ] . ':', true);
    }

    public function callAction(Element $element)
    {
        $url = Uri::createFromString($element->getAttribute('href'));
        $action = new Action($this, $url, $element);
        $params = explode(':', urldecode($url->getFragment()));


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
        $definitions = array_merge($definitions, $this->config[ 'links' ]);

        return array_merge($definitions, $this->document->attr('processors.links', [ ]));
    }

}
