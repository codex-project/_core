<?php
namespace Codex\Processors\Macros;

class General
{
    public function hide($isCloser = false)
    {
        return $isCloser ? '</div>' : '<div style="display:none">';
    }
}