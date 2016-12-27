<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CodexHttpException extends HttpException
{
    public static function documentNotFound($msg = '', $nr = 500)
    {
        return new static($nr, '[Document Not Found] ' . $msg);
    }

    public static function projectNotFound($msg = '', $nr = 500)
    {
        return new static($nr, '[Project Not Found] ' . $msg);
    }

    public static function authDriverNotSupported($msg = '', $nr = 500)
    {
        return new static($nr, '[Auth Driver Not Supported] ' . $msg);
    }
}