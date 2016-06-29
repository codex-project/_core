<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Exception;


use Codex\Documents\Document;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CodexException extends Exception
{
    protected $class;

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function toHttpException()
    {
        return new HttpException(404, $this->getMessage());
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


    public static function because($reason)
    {
        return new static($reason);
    }

    public static function in($class)
    {
        $exception = new static;
        $exception->setClass($class);
        return $exception;
    }


    public static function invalidMenuConfiguration($msg = '')
    {
        return new static('[Invalid Menu Configuration]' . $msg);
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

    public static function processorNotFound($msg = '', Document $document = null)
    {
        $msg = '[Processor Not Found] ' . $msg;
        if($document){
            $msg .= " for project: [{$document->getProject()->getName()}]";
        }
        return new static($msg);
    }

    public static function unsuportedMethodCall($msg = '')
    {
        return new static('[Unsuported Method Call] ' . $msg);
    }

    public static function implementationMismatch($if = '')
    {
        $if = strlen($if) > 0 ? "should implement {$if}" : '';
        return new static('[Implementation Mismatch] ' . $if);
    }
}
