<?php
namespace Codex\Addons\Processors\DocTags;

use Closure;
use Codex\Exception\CodexException;

/**
 * This is the class DocTag.
 *
 * @package        Codex\Addons
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
class Macro
{
    /** @var \Codex\Documents\Document */
    public $document;

    /** @var \Codex\Projects\Project */
    public $project;

    /** @var \Codex\Codex */
    public $codex;

    /** @var string */
    public $tag;

    /** @var string */
    public $handler;

    /** @var array */
    public $arguments = [ ];

    /** @var string */
    public $cleaned;

    /** @var string */
    public $raw;

    /**
     * DocTag constructor.
     *
     * @param string $raw
     * @param string $cleaned
     */
    public function __construct($raw, $cleaned)
    {
        $this->raw     = $raw;
        $this->cleaned = $cleaned;
    }


    public function isClosing()
    {
        return starts_with($this->cleaned, '/');
    }

    public function hasArguments()
    {
        return str_contains($this->cleaned, [ '(', ')' ]);
    }

    public function setTag($tag, $handler)
    {
        $this->tag     = $tag;
        $this->handler = $handler;
    }

    public function addArgument($arg)
    {
        $this->arguments[] = $this->transformArg($arg);
    }

    protected function transformArg($arg)
    {
        $arg = trim($arg);
        //https://regex101.com/r/gB9bP9/1

        if ( preg_match_all('/^(\'|\")(.*?)(\'|\")$/', $arg, $matches) > 0 )
        {
            return $matches[ 2 ][ 0 ];
        }
        elseif ( $arg === 'true' || $arg === 'false' )
        {
            return $arg === 'true';
        }
        elseif ( is_numeric($arg) )
        {
            return (int)$arg;
        }
        elseif ( class_exists((string)$arg) )
        {
            return app((string)$arg);
        }
        else
        {
            return $arg;
        }
    }

    protected function getCallable()
    {
        if ( $this->handler instanceof Closure )
        {
            return $this->handler;
        }
        else
        {
            // assuming its a @ string
            list($class, $method) = explode('@', (string)$this->handler);
            $instance = app()->make($class);
            foreach(['document', 'project', 'tag'] as $property){
                if(property_exists($instance, $property)){
                    $instance->{$property} = $this->{$property};
                }
            }
            return [ $instance, $method ];
        }
    }

    public function canRun()
    {
        return $this->raw && $this->cleaned && $this->handler && $this->tag;
    }

    public function run()
    {
        if ( $this->canRun() )
        {
            $content   = $this->document->getContent();
            $arguments = array_merge([ $this->isClosing() ], $this->arguments);
            $result    = call_user_func_array($this->getCallable(), $arguments);
            $content   = preg_replace('/' . preg_quote($this->raw, '/') . '/', $result, $content, 1);
            $this->document->setContent($content);
        }
        else
        {
            throw CodexException::because('DocTag cannot call because some properties havent been set. Prevent the DocTag from running by using the canRun() method.');
        }
    }
}
