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
namespace Codex\Processors\Links;

use Codex\Processors\LinksProcessor;
use Codex\Support\Traits\ConfigTrait;
use FluentDOM\Element;
use League\Uri\Schemes\Http;

/**
 * This is the class Action.
 *
 * @package        Codex\Processors
 * @author         Robin Radic
 */
class Action
{
    use ConfigTrait;

    /** @var LinksProcessor */
    protected $processor;

    /** @var Http */
    protected $url;

    /** @var Element */
    protected $element;

    /** @var array */
    protected $parameters = [ ];

    /** @var \Codex\Documents\Document */
    protected $document;

    /** @var \Codex\Projects\Project */
    protected $project;

    /** @var \Codex\Projects\Ref */
    protected $ref;

    /**
     * Action constructor.
     *
     * @param \Codex\Documents\Document        $document
     * @param \Codex\Processors\LinksProcessor $processor
     * @param \League\Uri\Schemes\Http         $url
     * @param \PHPHtmlParser\Dom\HtmlNode      $element
     */
    public function __construct(LinksProcessor $processor, Http $url, Element $element)
    {
        $this->processor = $processor;
        $this->document  = $processor->document;
        $this->project   = $processor->document->getProject();
        $this->ref       = $processor->document->getRef();
        $this->url       = $url;
        $this->element   = $element;
    }

    /**
     * setParameters method
     *
     * @param $parameters
     */
    public function setParameters($parameters)
    {
        if (is_array($parameters) && count($parameters) > 0) {
            $this->parameters = $parameters;
        }
    }

    /**
     * hasParameters method
     * @return bool
     */
    public function hasParameters()
    {
        return count($this->parameters) > 0;
    }

    /**
     * param method
     *
     * @param      $i
     * @param null $default
     *
     * @return null
     */
    public function param($i, $default = null)
    {
        return $this->hasParameter($i) ? $this->parameters[ $i ] : $default;
    }

    /**
     * hasParameter method
     *
     * @param $i
     *
     * @return bool
     */
    public function hasParameter($i)
    {
        return isset($this->parameters[ $i ]);
    }

    /**
     * call method
     * @return mixed
     */
    public function call()
    {
        return app()->call($this->config('call'), [ 'action' => $this ]);
    }

    /**
     * @return LinksProcessor
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @return Http
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return Element
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return \Codex\Documents\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return \Codex\Projects\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return \Codex\Projects\Ref
     */
    public function getRef()
    {
        return $this->ref;
    }
}
