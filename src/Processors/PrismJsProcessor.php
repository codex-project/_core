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
namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Codex;
use Codex\Documents\Document;
use Codex\Projects\Project;
use Codex\Support\Collection;
use Codex\Theme;
use FluentDOM\Element;
use Illuminate\Support\Traits\Macroable;
use Laradic\Support\Str;

/**
 * This is the class PrismJsProcessor.
 *
 * @package        Codex\Processors
 * @author         Robin Radic
 * @Processor("prismjs", config="config", after={"parser"}, forceCached=true)
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
        'copy-to-clipboard',
        'custom-class',
        'data-uri-highlight',
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
        'toolbar',
        'unescaped-markup',
        'wpd',
    ];

    protected $depends = [
        'show-language'     => [ 'toolbar' ],
        'copy-to-clipboard' => [ 'toolbar' ],
    ];

    /** @var Collection */
    public $config = 'codex.processors.prismjs';

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
        $this->addEnabledPlugins();
        if($document->hasCachedContent() === false) {
            $this->applyEnabledPlugins();
        }
    }

    protected function applyEnabledPlugins()
    {
        // apply the changes to the dom required by each plugin
        $dom = $this->document->getDom();
        $dom->find('//pre/code')->each(function (Element $code) {
            $pre       = $code->parentNode;
            $preClass  = $pre->getAttribute('class');
            $codeClass = $code->getAttribute('class');

            // detect language from <code class="language-xxx">
            // apply it to the <pre class> aswell
            $language           = false;
            $languageExpression = '/language-(.*?)(?:\s|$)/';
            if ( preg_match($languageExpression, $codeClass, $matches) === 1 ) {
                $preClass .= ' ' . $matches[ 0 ] . ' ';
                $language = $matches[ 1 ];
            }

            // line-numbers
            if ( $this->isEnabledPlugin('line-numbers') ) {
                $preClass .= ' line-numbers ';
            }

            // show-language
            if ( $this->isEnabledPlugin('show-language') && $language !== false ) {
                $pre->setAttribute('data-language', $language);
            }

            // command-line
            if ( $this->isEnabledPlugin('command-line') && in_array($language, [ 'bash', 'powershell' ], true) ) {
                $preClass .= ' command-line ';
                $preClass = str_replace('line-numbers', '', $preClass);
                $this->config->get('plugins.config.command-line')
                    ->filter(function ($val, $key) {
                        return $val !== false;
                    })->each(function ($val, $key) use ($pre) {
                        $pre->setAttribute($key, $val);
                    });
            }

            $pre->setAttribute('class', $preClass);
            $code->setAttribute('class', $codeClass);
        });
        $this->document->setDom($dom);
    }

    protected function addEnabledPlugins()
    {
        $this->getEnabledPlugins()->each(function ($name) {
            $this->addPlugin($name);
        });
    }

    protected function addBaseAssets()
    {
        if ( $this->config->get('css_path', false) !== false ) {
            $this->theme->addStylesheet('prismjs', $this->config[ 'css_path' ]);
        }
        if ( $this->config->get('js_path', false) !== false ) {
            $this->theme
                ->addJavascript('prismjs', $this->config[ 'js_path' ])
                ->javascripts(false)->customMerge([ 'prismjs' ], 'codex.depends', 'array_merge');
        }
    }

    protected function isSupportedPlugin($name)
    {
        return in_array($name, $this->plugins, true);
    }

    protected function isEnabledPlugin($name)
    {
        return $this->getEnabledPlugins()->contains($name);
    }

    protected function getPluginPath($name)
    {
        return $this->config[ 'plugin_path' ] . "/{$name}/prism-{$name}";
    }

    protected function getPluginDepends($name, $style = false)
    {
        $depends = [ 'prismjs' ];
        if ( array_key_exists($name, $this->depends) ) {

            $depends = array_merge($depends, array_map(function ($name) {
                return "prismjs-{$name}";
            }, $this->depends[ $name ]));


            if($style){
                // filter out the depends which dont have a stylesheet
                $depends = array_filter($depends, function($name) {
                    return $this->theme->stylesheets(false)->has($name);
                });
            }
        }
        return $depends;
    }

    protected function addPlugin($name)
    {
        $key = "prismjs-{$name}";
        if ( $this->isSupportedPlugin($name) && false === $this->theme->javascripts()->has($key) ) {
            // Check if a custom handler is registered and call that instead of using this global procedure
            $method = Str::camelize("add-{$name}-plugin");
            if ( static::hasMacro($method) || method_exists($this, $method) ) {
                return $this->{$method}($name);
            }

            // add script
            $this->theme->addJavascript($key, $this->getPluginPath($name), $this->getPluginDepends($name));

            // add style
            if ( file_exists(public_path($this->getPluginPath($name) . '.css')) ) {
                $this->theme->addStylesheet($key, $this->getPluginPath($name), $this->getPluginDepends($name, true));
            }

            // add javascript configuration (Prism.plugins)
            if ( $this->config->has("plugins.config.{$name}.javascript") ) {
                $pluginConfig = $this->config->get("plugins.config.{$name}.javascript");
                if ( $pluginConfig->isEmpty() === false ) {
                    $this->theme->addScript($key, <<<JS
(function(){
    var config = {$pluginConfig->toJson()};
    var configKeys = Object.keys(config);
    for(var i in configKeys){
        Prism.plugins['{$name}'][configKeys[i]] = config[configKeys[i]];
    }
}.call())
JS
                    );
                }
            }
        }
    }

    /**
     * getEnabledPlugins method
     * @return mixed|Collection
     */
    protected function getEnabledPlugins()
    {
        return $this->config->get('plugins.enabled');
    }
}
