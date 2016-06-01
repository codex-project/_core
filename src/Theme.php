<?php
namespace Codex\Core;

use Codex\Core\Contracts\Codex;
use Codex\Core\Contracts\Extendable;
use Codex\Core\Contracts\Hookable;
use Codex\Core\Support\Collection;
use Codex\Core\Support\Sorter;
use Codex\Core\Traits\ExtendableTrait;
use Codex\Core\Traits\HookableTrait;
use Sebwite\Support\Str;

class Theme implements
    Extendable,
    Hookable
{
    use ExtendableTrait,
        HookableTrait;

    /** @var Collection */
    protected $data;

    /** @var \Codex\Core\Contracts\Codex|\Codex\Core\Codex */
    protected $codex;

    /** @var \Codex\Core\Support\Collection */
    protected $javascripts;

    /** @var \Codex\Core\Support\Collection */
    protected $stylesheets;

    /**
     * Theme constructor.
     *
     * @param \Codex\Core\Contracts\Codex|\Codex\Core\Codex $parent
     */
    public function __construct(Codex $parent)
    {
        $this->codex = $parent;
        $this->data  = new Collection;
        $this->emptyAssets();
    }

    /**
     * set method
     *
     * @param $key
     * @param $value
     *
     * @return Theme
     */
    public function set($key, $value)
    {
        $this->data->put($key, $value);
        return $this;
    }

    /**
     * addJavascript method
     *
     * @param       $name
     * @param       $src
     * @param array $depends
     * @param bool  $external
     *
     * @return $this
     */
    public function addJavascript($name, $src, array $depends = [ ], $external = false)
    {
        $src = Str::ensureRight($src, '.js');
        $src = $external ? $src : asset($src);
        $this->javascripts->put($name, compact('src', 'depends', 'external', 'name'));
        return $this;
    }

    /**
     * addStylesheet method
     *
     * @param       $name
     * @param       $src
     * @param array $depends
     * @param bool  $external
     *
     * @return \Codex\Core\Theme
     */
    public function addStylesheet($name, $src, array $depends = [ ], $external = false)
    {
        $src = Str::ensureRight($src, '.css');
        $src = $external ? $src : asset($src);
        $this->stylesheets->put($name, compact('src', 'depends', 'external', 'name'));
        return $this;
    }

    /**
     * data method
     * @return \Codex\Core\Support\Collection
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Get the javascripts collection
     * @return \Codex\Core\Support\Collection
     */
    public function javascripts()
    {
        return $this->sortAssets($this->javascripts);
    }

    /**
     * Get the stylesheets collection
     * @return \Codex\Core\Support\Collection
     */
    public function stylesheets()
    {
        return $this->sortAssets($this->stylesheets);
    }

    /**
     * renderJsData method
     * @return string
     */
    public function renderData()
    {
        return "<script> window['_CODEX_PHP_DATA'] = {$this->data->toJson()}; </script>";
    }

    /**
     * renderJavascripts method
     * @return string
     */
    public function renderJavascripts()
    {
        $scripts = [ ];
        foreach ( $this->javascripts() as $js ) {
            $scripts[] = "<script src=\"{$js['src']}\"></script>";
        }
        return implode("\n", $scripts);
    }


    /**
     * renderStylesheets method
     * @return string
     */
    public function renderStylesheets()
    {
        $styles = [ ];
        foreach ( $this->stylesheets() as $css ) {
            $styles[] = "<link type='text/css' rel='stylesheet' href=\"{$css['src']}\"/>";
        }
        return implode("\n", $styles);
    }

    /**
     * Empties the assets. Removes all javascripts and stylesheets.
     * @return Theme
     */
    public function emptyAssets()
    {
        $this->javascripts = new Collection;
        $this->stylesheets = new Collection;
        return $this;
    }

    /**
     * sortAssets method
     *
     * @param array|Collection $assets
     *
     * @return \Codex\Core\Support\Collection
     */
    protected function sortAssets($assets = [ ])
    {
        $assets = $assets instanceof Collection ? $assets : new Collection($assets);
        $sorter = new Sorter;
        $sorted = new Collection;
        foreach ( $assets as $name => $asset ) {
            $sorter->addItem($asset['name'], $asset['depends']);
        }

        foreach($sorter->sort() as $name){
            $sorted->add($assets->where('name', $name)->first());
        }

        return $sorted;
    }
}