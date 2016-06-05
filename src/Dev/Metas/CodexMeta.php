<?php
namespace Codex\Dev\Metas;

use Sebwite\IdeaMeta\Metas\BaseMeta;

class CodexMeta extends BaseMeta
{
    protected $methods = [
        'new \Codex\Codex',
        'codex(\'\')',
    ];

    public function getData()
    {
        return app('Codex\Contracts\Codex')->getExtenableProperty('extensions');
    }

    public static function canRun()
    {
        return true;
    }
}
