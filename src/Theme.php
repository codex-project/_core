<?php
namespace Codex\Core;

use Codex\Core\Contracts\Codex;
use Codex\Core\Support\Collection;

class Theme
{
    /** @var Collection */
    protected $jsData;

    /** @var \Codex\Core\Contracts\Codex|\Codex\Core\Codex */
    protected $codex;

    /**
     * Theme constructor.
     *
     * @param \Codex\Core\Contracts\Codex|\Codex\Core\Codex $parent
     */
    public function __construct(Codex $parent)
    {
        $this->codex  = $parent;
        $this->jsData = new Collection;
    }


    public function addJsData($key, $value)
    {
        $this->jsData->put($key, $value);
    }

    public function renderJsData()
    {
        return "<script> window['_CODEX_PHP_DATA'] = {$this->jsData->toJson()}; </script>";
    }
}