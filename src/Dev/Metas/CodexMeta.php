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
namespace Codex\Dev\Metas;

use Laradic\Idea\Metadata\Metas\BaseMeta;

class CodexMeta extends BaseMeta
{
    protected $methods = [
        'new \\Codex\\Codex',
        '\\codex(\'\')',
    ];

    public function getData()
    {
        return \Codex\Codex::getExtenableProperty('extensions');
    }

    public static function canRun()
    {
        return true;
    }
}
