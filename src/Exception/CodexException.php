<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Exception;


use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CodexException extends Exception
{
    protected $class;

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function because($reason)
    {
        return new static($reason);
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

    public static function configFileMissing($msg = '')
    {
        return new static('[Config File Missing] ' . $msg);
    }

    public static function documentNotFound($msg = '')
    {
        return new static('[Document Not Found] ' . $msg);
    }

    public static function projectNotFound($msg = '')
    {
        return new static('[Project Not Found] ' . $msg);
    }

    public static function manifestNotFound($msg = '')
    {
        return new static('[Manifest Not Found] ' . $msg);
    }

    public static function manifestParse($msg = '')
    {
        return new static('[Manifest Parse] ' . $msg);
    }

    public function toHttpException()
    {
        return new HttpException(404, $this->getMessage());
    }
}
