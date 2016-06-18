<?php
namespace Codex\Addons\Processors\DocTags;

class General
{
    public function hide($isCloser = false)
    {
        return $isCloser ? '</div>' : '<div style="display:none">';
    }
}