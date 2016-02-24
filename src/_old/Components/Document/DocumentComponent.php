<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Components\Document;

use BadMethodCallException;
use Codex\Core\Document;
use Sebwite\Support\Traits\Extendable;

/**
 * This is the class DocumentComponent.
 *
 * @package        Codex\Core
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class DocumentComponent
{
    use Extendable;

    protected $document;

    /**
     * Component constructor.
     *
     * @param \Sebwite\Workbench\Contracts\Workbench $codex
     */
    public function __construct(Document $parent)
    {
        $this->document = $parent;
    }

    /**
     * @return WorkbenchContract|Workbench
     */
    public function getDocument()
    {
        return $this->document;
    }

    public function getContainer()
    {
        return \Illuminate\Container\Container::getInstance();
    }


    public function __call($method, $params)
    {
        $doc = $this->document;

        if (array_key_exists($method, static::$extensions)) {
            return $this->callExtension($method, $params);
        } elseif (method_exists($doc, $method) || array_key_exists($method, $doc::extensions())) {
            return call_user_func_array([ $doc, $method ], $params);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
