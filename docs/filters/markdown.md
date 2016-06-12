<!--
title: Markdown
subtitle: Filters
-->

# Markdown

### Overview

**API Documentation:** [MarkdownFilter](#phpdoc:popover:Codex\Addons\Filters\MarkdownFilter)

This filter is responsible for transforming Markdown documents into HTML. 

### Configuration
Below is the default configuration. This goes into your `docs/{project-name}/config.php`
```php
[
    'filters' => [
        'enabled' => ['markdown'],
        'markdown' => [        
            'renderer'  => 'Codex\Addons\Filters\Markdown\CodexMarkdownRenderer',
            'codex'     => [
                // renderer specific config. Some renderers might have it, some not
            ],
        ]
    ]
];
```    

### Use custom renderer
It is possible to change the default `renderer` to a custom implementation. For example, if you'd rather have `Parsedown` 
handle the Markdown > HTML transformation, you can use the [`RendererInterface`](#phpdoc:popover:Codex\Addons\Filters\Markdown\RendererInterface)
to implement it and then configure by setting the `renderer` option value to that custom class.
```php
[
    'filters' => [
        'enabled' => ['markdown'],
        'markdown' => [        
            'renderer'  => 'App\Markdown\ParsedownRenderer',
            'parsedown' => [
                'markup_escaped' => true,
            ]
        ]
    ]
];    
```    

This requires you to create your own Renderer. Which is easy to create:

```php
namespace App\Markdown;

use Codex\Addons\Filters\Markdown\RendererInterface;

class ParsedownRenderer implements RendererInterface {

    protected $config = ['markup_escaped' => false];
    
    public function getName(){
        return 'parsedown';
    }
    
    public function render($string){
        $parsedown = new \Parsedown();
        $parsedown->setMarkupEscaped($this->config['markup_escaped']);
        return $parsedown->text($string);
    }

    public function setConfig($config = [ ]){
        $this->config = array_replace_recursive($this->config, $config);
    }
}
```