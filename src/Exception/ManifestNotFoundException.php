<?php
namespace Codex\Core\Exception;

class ManifestNotFoundException extends CodexException
{
    public static function manifestPath($path)
    {
        return static::because("Manifest path [$path] is not a readable JSON file");
    }
}