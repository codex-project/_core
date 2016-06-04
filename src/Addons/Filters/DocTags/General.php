<?php
namespace Codex\Addons\Filters\DocTags;

class General
{
    public function hide($isCloser = false)
    {
        return $isCloser ? '</div>' : '<div style="display:none">';
    }
}