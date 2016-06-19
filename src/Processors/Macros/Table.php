<?php
namespace Codex\Processors\Macros;

class Table
{
    public function responsive($isCloser = false, $num = null, $str = null, $int = null)
    {
        return $isCloser ? '</div>' : '<div class="responsive">';
    }
}