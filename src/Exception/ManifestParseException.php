<?php
namespace Codex\Core\Exception;

class ManifestParseException extends CodexException
{
    public static function isEmpty()
    {
        return static::because('manifest was empty');
    }
}