<?php
namespace Codex\Core;

use Codex\Core\Contracts\Codex as CodexContract;
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

    /** @var \Codex\Core\Support\Collection */
    protected $scripts;

    /** @var \Codex\Core\Support\Collection */
    protected $styles;

    /**
     * Theme constructor.
     *
     * @param \Codex\Core\Contracts\Codex|\Codex\Core\Codex $parent
     */
    public function __construct(CodexContract $parent)
    {
        $this->codex = $parent;
        $this->data  = new Collection;
        $this->reset();
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

    public function addScript($name, $value, array $depends = [ ], array $attr = [ ])
    {
        $this->scripts->set($name, compact('name', 'value', 'depends', 'attr'));
    }
    public function addStyle($name, $value, array $depends = [ ], array $attr = [ ])
    {
        $this->styles->set($name, compact('name', 'value', 'depends', 'attr'));
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
        return $this->sorter($this->javascripts);
    }

    /**
     * Get the stylesheets collection
     * @return \Codex\Core\Support\Collection
     */
    public function stylesheets()
    {
        return $this->sorter($this->stylesheets);
    }

    /**
     * styles method
     * @return \Codex\Core\Support\Collection
     */
    public function styles()
    {
        return $this->sorter($this->styles);
    }

    /**
     * scripts method
     * @return \Codex\Core\Support\Collection
     */
    public function scripts()
    {
        return $this->sorter($this->scripts);
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
     * renderStyles method
     * @return string
     */
    public function renderStyles()
    {
        $styles = [ ];
        foreach ( $this->styles() as $style ) {
            $styles[] = "<style type='text/css'>{$style['value']}</style>";
        }
        return implode("\n", $styles);
    }

    /**
     * renderJavascripts method
     * @return string
     */
    public function renderScripts()
    {
        $scripts = [ ];
        foreach ( $this->scripts() as $js ) {
            $scripts[] = "<script>{$js['value']}</script>";
        }
        return implode("\n", $scripts);
    }


    /**
     * Empties the assets. Removes all javascripts and stylesheets.
     * @return Theme
     */
    public function reset()
    {
        $this->javascripts = new Collection;
        $this->stylesheets = new Collection;
        $this->scripts     = new Collection;
        $this->styles      = new Collection;
        return $this;
    }
    /**
     * sortAssets method
     *
     * @param array|Collection $all
     *
     * @return \Codex\Core\Support\Collection
     */
    protected function sorter($all = [ ])
    {
        $all    = $all instanceof Collection ? $all : new Collection($all);
        $sorter = new Sorter;
        $sorted = new Collection;
        foreach ( $all as $name => $asset ) {
            $sorter->addItem($asset[ 'name' ], $asset[ 'depends' ]);
        }

        foreach ( $sorter->sort() as $name ) {
            $sorted->add($all->where('name', $name)->first());
        }

        return $sorted;
    }
}