<?php
namespace Codex\Dev\Metas;


use Laradic\Phpstorm\Autocomplete\Metas\BaseMeta;

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
