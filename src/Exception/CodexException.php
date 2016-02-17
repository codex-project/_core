<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Exception;


use Exception;

class CodexException extends Exception
{
    protected $class;

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function because($reason)
    {
        return $this->setMessage($reason);
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setClass($class)
    {
        if(!is_string($class)){
            $class = get_class($class);
        }
        $this->class = $class;
        return $this;
    }

    public static function in($class)
    {
        $exception = new static;
        $exception->setClass($class);
        return $exception;
    }
}
