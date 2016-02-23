<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Exception;


/**
 * This is the class ConfigFileNotPublished.
 *
 * @package        Codex\Core
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 *
 */
class ConfigFileNotPublished extends CodexException
{
    public function filePath($path)
    {
        return new static("Config file [{$path}] not published");
    }
}
