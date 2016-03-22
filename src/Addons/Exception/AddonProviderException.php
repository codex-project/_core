<?php
namespace Codex\Core\Addons\Exception;

class AddonProviderException extends \Exception
{
    public static function namePropertyNotDefined()
    {
        return new static('The name property has not been defined');
    }
}
