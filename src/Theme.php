<?php
namespace Codex;

use Codex\Contracts\Codex as CodexContract;
use Codex\Contracts\Extendable;
use Codex\Contracts\Hookable;
use Codex\Support\Collection;
use Codex\Support\Sorter;
use Codex\Traits\ExtendableTrait;
use Codex\Traits\HookableTrait;
use Sebwite\Support\Str;

class Theme implements
    Extendable,
    Hookable
{
    use ExtendableTrait,
        HookableTrait;

    /** @var Collection */
    protected $data;

    /** @var \Codex\Contracts\Codex|\Codex\Codex */
    protected $codex;

    /** @var \Codex\Support\Collection */
    protected $javascripts;

    /** @var \Codex\Support\Collection */
    protected $stylesheets;

    /** @var \Codex\Support\Collection */
    protected $scripts;

    /** @var \Codex\Support\Collection */
    protected $styles;

    /** @var array  */
    protected $bodyClass = [ ];

    /**
     * Theme constructor.
     *
     * @param \Codex\Contracts\Codex|\Codex\Codex $parent
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
     * @return \Codex\Theme
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
     * @return \Codex\Theme
     */
    public function addStylesheet($name, $src, array $depends = [ ], $external = false)
    {
        $src = Str::ensureRight($src, '.css');
        $src = $external ? $src : asset($src);
        $this->stylesheets->put($name, compact('src', 'depends', 'external', 'name'));
        return $this;
    }

    /**
     * addScript method
     *
     * @param       $name
     * @param       $value
     * @param array $depends
     * @param array $attr
     *
     * @return Theme
     */
    public function addScript($name, $value, array $depends = [ ], array $attr = [ ])
    {
        $this->scripts->set($name, compact('name', 'value', 'depends', 'attr'));
        return $this;
    }

    /**
     * addStyle method
     *
     * @param       $name
     * @param       $value
     * @param array $depends
     * @param array $attr
     *
     * @return Theme
     */
    public function addStyle($name, $value, array $depends = [ ], array $attr = [ ])
    {
        $this->styles->set($name, compact('name', 'value', 'depends', 'attr'));
        return $this;
    }

    /**
     * data method
     * @return \Codex\Support\Collection
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Get the javascripts collection
     * @return \Codex\Support\Collection
     */
    public function javascripts()
    {
        return $this->sorter($this->javascripts);
    }

    /**
     * Get the stylesheets collection
     * @return \Codex\Support\Collection
     */
    public function stylesheets()
    {
        return $this->sorter($this->stylesheets);
    }

    /**
     * styles method
     * @return \Codex\Support\Collection
     */
    public function styles()
    {
        return $this->sorter($this->styles);
    }

    /**
     * scripts method
     * @return \Codex\Support\Collection
     */
    public function scripts()
    {
        return $this->sorter($this->scripts);
    }

    /**
     * addBodyClass method
     *
     * @param string|array $class
     */
    public function addBodyClass($class)
    {
        $classes = is_array($class) ? $class : explode(' ', $class);
        foreach ( $classes as $c ) {
            if ( $this->hasBodyClass($c) === false ) {
                $this->bodyClass[] = $c;
            }
        }
    }

    public function setBodyClass($val)
    {
        $this->bodyClass = $val;
        return $this;
    }

    public function getBodyClass()
    {
        return $this->bodyClass;
    }

    public function renderBodyClass()
    {
        return implode(' ', $this->bodyClass);
    }

    public function hasBodyClass($class)
    {
        return in_array($class, $this->bodyClass, true);
    }

    public function removeBodyClass($classes)
    {
        $classes = is_array($classes) ? $classes : explode(' ', $classes);
        $this->bodyClass = array_diff($this->bodyClass, $classes);
        return $this;
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
        $this->body        = new Collection;
        return $this;
    }

    /**
     * sortAssets method
     *
     * @param array|Collection $all
     *
     * @return \Codex\Support\Collection
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