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
namespace Codex\Dev\Debugbar;

use Barryvdh\Debugbar\DataCollector\LogsCollector;

class CodexLogsCollector extends LogsCollector
{
    public function getLogsFile()
    {
        return storage_path(config('codex.paths.log'));
    }
}
