<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex;

use Closure;
use Codex\Codex;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Support\Sorter;
use Illuminate\Contracts\Support\Arrayable;
use Laradic\Support\Str;

class Theme extends Extendable implements Arrayable
{
    const JAVASCRIPT = 'js';
    const STYLESHEET = 'css';
    const SCRIPT = 'script';
    const STYLE = 'style';


    /** @var Collection */
    protected $data;

    /** @var \Codex\Support\Collection */
    protected $javascripts;

    /** @var \Codex\Support\Collection */
    protected $stylesheets;

    /** @var \Codex\Support\Collection */
    protected $scripts;

    /** @var \Codex\Support\Collection */
    protected $styles;


    /**
     * Theme constructor.
     *
     * @param \Codex\Codex $parent
     */
    public function __construct(Codex $parent)
    {
        $this->setCodex($parent);
        $this->reset();
        #$this->scripts = new Theme\Scripts;
    }

    /**
     * set method
     *
     * @param $key
     * @param $value
     *
     * @return static
     */
    public function set($key, $value = null)
    {
        $this->data->set($key, $value);

        return $this;
    }

    /**
     * Push a view to a stack
     *
     * @param string     $stackName   The name of the stack
     * @param string     $viewName    The namespaced name of the view
     * @param array|null $data        (optional) The view data array
     * @param string     $targetViews (optional) The view to attach this to
     *
     * @return static
     */
    public function pushViewToStack($stackName, $targetViews, $viewName, $data = null)
    {
        $this->pushContentToStack($stackName, $targetViews, function ($view) use ($viewName, $data) {
            /** @var \Illuminate\View\View $view */
            if ($data instanceof \Closure) {
                $data = $this->codex->getContainer()->call($data, [ $this ]);
                $data = is_array($data) ? $data : [ ];
            } elseif ($data === null) {
                $data = [ ];
            }
            if (!is_array($data)) {
                throw new \InvalidArgumentException("appendSectionsView data is not a array");
            }

            return $view->getFactory()->make($viewName, $data)->render();
        });

        return $this;
    }

    public function pushContentToStack($stackName, $targetViews, $content)
    {
        $targetViews = is_array($targetViews) ? $targetViews : [$targetViews];
        foreach ($targetViews as $targetView) {
            $this->codex->getContainer()->make('events')->listen('composing: ' . $targetView, function ($view) use ($stackName, $content) {
                $view->getFactory()->startPush($stackName, $content instanceof Closure ? $content($view) : $content);
            });
        }

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
     * @return Theme
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
     * @return static
     */
    public function addScript($name, $value, array $depends = [ ], array $attr = [ ])
    {
        $this->scripts->put($name, compact('name', 'value', 'depends', 'attr'));

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
     * @return static
     */
    public function addStyle($name, $value, array $depends = [ ], array $attr = [ ])
    {
        $this->styles->set($name, compact('name', 'value', 'depends', 'attr'));

        return $this;
    }


    /**
     * data method
     *
     * @return \Codex\Support\Collection
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Get the javascripts collection
     *
     * @return \Codex\Support\Collection
     */
    public function javascripts($sorted = true)
    {
        return $sorted ? $this->sorter($this->javascripts) : $this->javascripts;
    }

    /**
     * Get the stylesheets collection
     *
     * @return \Codex\Support\Collection
     */
    public function stylesheets($sorted = true)
    {
        return $sorted ? $this->sorter($this->stylesheets) : $this->stylesheets;
    }

    /**
     * styles method
     *
     * @return \Codex\Support\Collection
     */
    public function styles($sorted = true)
    {
        return $sorted ? $this->sorter($this->styles) : $this->styles;
    }

    /**
     * scripts method
     *
     * @return \Codex\Support\Collection
     */
    public function scripts($sorted = true)
    {
        return $sorted ? $this->sorter($this->scripts) : $this->scripts;
    }

    /**
     * renderJsData method
     *
     * @return string
     */
    public function renderData()
    {
        return "<script> window['_CODEX_PHP_DATA'] = {$this->data->toJson()}; </script>";
    }

    /**
     * renderJavascripts method
     *
     * @return string
     */
    public function renderJavascripts()
    {
        $scripts = [ ];
        foreach ($this->javascripts() as $js) {
            $scripts[] = "<script src=\"{$js['src']}\"></script>";
        }

        return implode("\n", $scripts);
    }

    /**
     * renderStylesheets method
     *
     * @return string
     */
    public function renderStylesheets()
    {
        $styles = [ ];
        foreach ($this->stylesheets() as $css) {
            $styles[] = "<link type='text/css' rel='stylesheet' href=\"{$css['src']}\"/>";
        }

        return implode("\n", $styles);
    }

    /**
     * renderStyles method
     *
     * @return string
     */
    public function renderStyles()
    {
        $styles = [ ];
        foreach ($this->styles() as $style) {
            $styles[] = "<style type='text/css'>{$style['value']}</style>";
        }

        return implode("\n", $styles);
    }

    /**
     * renderJavascripts method
     *
     * @return string
     */
    public function renderScripts()
    {
        $scripts = [ ];
        foreach ($this->scripts() as $js) {
            $scripts[] = "<script>{$js['value']}</script>";
        }

        return implode("\n", $scripts);
    }


    public function view($name, $view = null)
    {
        $this->codex->view($name, $view);
    }

    /**
     * Empties the assets. Removes all javascripts and stylesheets.
     *
     * @return static
     */
    public function reset()
    {
        $this->javascripts = new Collection;
        $this->stylesheets = new Collection;
        $this->scripts     = new Collection;
        $this->styles      = new Collection;
        $this->data        = new Collection;
        $this->title = $this->getCodex()->config('codex.display_name');

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
        foreach ($all as $name => $asset) {
            $sorter->addItem($asset[ 'name' ], $asset[ 'depends' ]);
        }

        foreach ($sorter->sort() as $name) {
            $sorted->add($all->where('name', $name)->first());
        }

        return $sorted;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data       = [ 'bodyClass' => $this->bodyClass ];
        $arrayables = [
            'javascripts',
            'stylesheets',
            'scripts',
            'styles',
            'data',
        ];
        foreach ($arrayables as $arrayable) {
            $data[ $arrayable ] = call_user_func([
                $this,
                $arrayable,
            ])->toArray();
        }

        return $data;
    }
}
