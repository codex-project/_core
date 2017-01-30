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
    protected $parameters = [];

    /** @var array|Modifier[] */
    protected $modifiers = [];

    /** @var \Codex\Documents\Document */
    protected $document;

    /** @var \Codex\Projects\Project */
    protected $project;

    /** @var \Codex\Projects\Ref */
    protected $ref;

    protected $id;

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

        $this->parse($url->getFragment());
    }

    protected function parse($str)
    {

        $result = preg_match('/codex:(.*?)(?:\[(.*?)\]|$|)(?:(:.*)|$)/', urldecode($str), $matches);
        if ( $result === 0 ) {
            die('no results');
        }
        list($_, $id, $params, $modifiers) = $matches;
        $hasParams = strlen($params) > 0;
        $params    = $hasParams ? explode(',', $params) : [];
        $this->parseParams($params);
        $this->parameters = $params;

        $hasModifiers = strlen($modifiers) > 0;
        $modifiers    = $hasModifiers ? explode(':', str_remove_left($modifiers, ':')) : [];
        $modifiers    = array_map(function ($modifier) {
            $name    = $modifier;
            $params = [];
            if ( stristr($modifier, '[') ) {
                preg_match('/(.*?)\[(.*?)\]/', $modifier, $mparams);
                $params = explode(',', $mparams[ 2 ]);
                $this->parseParams($params);
            }
            return compact('name', 'params');
        }, $modifiers);
        foreach($modifiers as $modifier){
            $this->modifiers[$modifier['name']] = new Modifier($modifier['name'], $modifier['params']);
        }

        $this->id         = $id;
//        return (object) compact('id', 'params', 'hasParams', 'modifiers', 'hasModifiers');
    }

    protected function parseParams(array &$params)
    {
        $params = array_map(function ($param) {
            $param = trim($param);
            if ( starts_with($param, '"') ) {
                $param = str_remove_left(str_remove_right($param, '"'), '"');
            } elseif ( starts_with($param, '\'') ) {
                $param = str_remove_left(str_remove_right($param, '\''), '\'');
            } elseif ( is_numeric($param) ) {
                $param = (int)$param;
            } elseif ( is_bool($param) || $param === 'true' || $param === 'false' ) {
                $param = (bool)$param;
            }
            return $param;
        }, $params);
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

    public function containsParameter($str)
    {
        return in_array($str, $this->parameters, true);
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
     * hasModifiers method
     * @return bool
     */
    public function hasModifiers()
    {
        return count($this->modifiers) > 0;
    }

    /**
     * modifier method
     *
     * @param      $i
     * @param null $default
     *
     * @return \Codex\Processors\Links\Modifier|mixed|null
     */
    public function modifier($i, $default = null)
    {
        return $this->hasModifier($i) ? $this->modifiers[ $i ] : $default;
    }

    public function containsModifier($str)
    {
        return array_key_exists($str, $this->modifiers);
    }

    /**
     * hasModifier method
     *
     * @param $i
     *
     * @return bool
     */
    public function hasModifier($i)
    {
        return isset($this->modifiers[ $i ]);
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

    public function getId()
    {
        return $this->id;
    }
}
