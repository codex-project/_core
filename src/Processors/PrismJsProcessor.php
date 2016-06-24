<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Codex;
use Codex\Documents\Document;
use Codex\Projects\Project;
use Codex\Support\Collection;
use Codex\Theme;
use FluentDOM\Element;
use Illuminate\Support\Traits\Macroable;
use Sebwite\Support\Str;

/**
 * This is the class PrismJsProcessor.
 *
 * @package        Codex\Processors
 * @author         Robin Radic
 * @Processor("prismjs", config="config", after={"parser"})
 */
class PrismJsProcessor
{
    use Macroable;

    /**
     * The list of supported plugins
     * @var array
     */
    protected $plugins = [
        'autolinker',
        'autoloader',
        'command-line',
        'file-highlight',
        'highlight-keywords',
        'ie8',
        'jsonp-highlight',
        'keep-markup',
        'line-highlight',
        'line-numbers',
        'normalize-whitespace',
        'previewer-angle',
        'previewer-base',
        'previewer-color',
        'previewer-easing',
        'previewer-gradient',
        'previewer-time',
        'remove-initial-line-feed',
        'show-invisibles',
        'show-language',
        'unescaped-markup',
        'wpd',
    ];

    /** @var Collection */
    public $config = [
        'js_path'                  => 'vendor/codex/vendor/prism/prism.js',
        'css_path'                 => 'vendor/codex/styles/prism.css',
        'plugin_path'              => 'vendor/codex/vendor/prism/plugins',
        'plugins'                  => [
            // enabled plugins
//            'autolinker',
            'autoloader',
//            'command-line',
//            'file-highlight',
//            'highlight-keywords',
//            'ie8',
//            'jsonp-highlight',
//            'keep-markup',
//            'line-highlight',
//            'line-numbers',
//            'normalize-whitespace',
//            'previewer-angle',
//            'previewer-base',
//            'previewer-color',
//            'previewer-easing',
//            'previewer-gradient',
//            'previewer-time',
//            'remove-initial-line-feed',
//            'show-invisibles',
//            'show-language',
//            'unescaped-markup',
//            'wpd',
        ],

        // plugin config
        'autolinker'               => [ ],
        'autoloader'               => [
            'languages_path' => '/vendor/codex/vendor/prism/components/',
            'use_minified'   => true,
        ],
        'command-line'             => [ ],
        'file-highlight'           => [ ],
        'highlight-keywords'       => [ ],
        'ie8'                      => [ ],
        'jsonp-highlight'          => [ ],
        'keep-markup'              => [ ],
        'line-highlight'           => [ ],
        'line-numbers'             => [ ],
        'normalize-whitespace'     => [ ],
        'previewer-angle'          => [ ],
        'previewer-base'           => [ ],
        'previewer-color'          => [ ],
        'previewer-easing'         => [ ],
        'previewer-gradient'       => [ ],
        'previewer-time'           => [ ],
        'remove-initial-line-feed' => [ ],
        'show-invisibles'          => [ ],
        'show-language'            => [ ],
        'unescaped-markup'         => [ ],
        'wpd'                      => [ ],
    ];

    /** @var Codex */
    public $codex;

    /** @var Project */
    public $project;

    /** @var Document */
    public $document;

    /** @var Theme */
    protected $theme;

    public function handle(Document $document)
    {
        $this->theme = $this->codex->theme;
        $this->addBaseAssets();
        foreach ( $this->config['plugins'] as $plugin )
        {
            $this->addPlugin($plugin);
        }

        return;
        $dom = $document->getDom();
        $dom->find('//pre/code')->each(function (Element $el)
        {
            $cls = $el->getAttribute('class');

            $a = 'a';
        });
    }

    protected function addBaseAssets()
    {
        $this->theme->addStylesheet('prism', $this->config[ 'css_path' ], [ 'theme' ]);
        $this->theme->addJavascript('prism', $this->config[ 'js_path' ], [ 'theme' ]);
    }

    protected function isValidPlugin($name)
    {
        return in_array($name, $this->plugins, true);
    }

    protected function isEnabledPlugin($name)
    {
        return $this->config->has("plugins.{$name}");
    }

    protected function getPluginPath($name)
    {
        return $this->config[ 'plugin_path' ] . "/{$name}/prism-{$name}";
    }

    protected function getPluginJsonConfig($name, $key = null)
    {
        $name = $key === null ? $name : $name . '.' . $key;
        return json_encode($this->config[ $name ]);
    }

    protected function addPlugin($name)
    {

        if ( $this->isValidPlugin($name) && false === $this->theme->javascripts()->has($key = "prism-{$name}") )
        {
            $this->theme->addJavascript($key, $this->getPluginPath($name), [ 'prism' ]);
            if ( file_exists(public_path($this->getPluginPath($name) . '.css')) )
            {
                $this->theme->addStylesheet($key, $this->getPluginPath($name), [ 'prism' ]);
            }

            $method = Str::camelize("add-{$name}-plugin");
            if ( static::hasMacro($method) || method_exists($this, $method) )
            {
                $this->{$method}($name);
            }
        }
    }

    protected function getEnabledPlugins()
    {
        return $this->config->except('js_path', 'css_path', 'plugin_path', 'plugins')->keys()->toArray();
    }

    protected function addAutoloaderPlugin($name)
    {
        $this->theme->addScript($name, <<<JS
Prism.plugins.autoloader.languages_path = {$this->getPluginJsonConfig($name, 'languages_path')};
Prism.plugins.autoloader.use_minified = {$this->getPluginJsonConfig($name, 'use_minified')};
JS
        );
    }
}