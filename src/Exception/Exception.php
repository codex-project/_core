<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Exception;

class Exception extends \Exception
{
    /**
     * Set the message value
     *
     * @param mixed $message
     *
     * @return Exception
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set the code value
     *
     * @param mixed $code
     *
     * @return Exception
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Set the file value
     *
     * @param mixed $file
     *
     * @return Exception
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Set the line value
     *
     * @param mixed $line
     *
     * @return Exception
     */
    public function setLine($line)
    {
        $this->line = $line;
        return $this;
    }

    public static function create($message, $code = 0, $previous = null)
    {
        return new static($message, $code, $previous);
    }
}
