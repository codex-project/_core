<!--
title: Refactor
subtitle: Cause it was needesd
-->
# Codex\Core
  
  
    - `Codex\Core`
        - `Codex::class` # `codex()`
        - `Addons`
            - `Annotations`
                - Document::class   # @Document
                - Filter::class     # @Filter
                - Hook::class       # @Hook
            - `Exception`
            - `Scanner`
                - Scanner::class
                - Finder::class
            - Addons::class         # codex()->getAddons()
            - AddonInterface::interface
            - AddonType::enum
            - AddonServiceProvider::class
        - `Projects`
            - `Projects::class`     # codex()->projects
            - `Project::class`      # codex()->projects->get('name')
        - `Menus`
              - `Menus::class`      # codex()->menus
              - `Menu::class`       # codex()->menus->get('name')
              - `Node::class`       # codex()->menus->get('name')->getChildren()[0]    
        - `Documents`
              - `Documents::class`  # codex()->projects->get('name')->documents
              - `Document::class`   # codex()->projects->get('name')->documents->get('index')
        - `Filesystem`
            - `Local::class`



# Codex
#### Trigger

    codex()->trigger('document:content:render', $content);
    codex()->on('document:content:render', function(Document $document){
        $content = $document->getContent();
        $content = str_replace('title', 'Welcome!!', $content);
        $document->setContent($content)
    });
    
    
#### Document
```php
use Codex\Core\Addons\Annotations\Document;
/**
* This is the class MarkdownContentRenderer.
 *
 * @author CLI
 * @copyright Copyright (c) 2015, CLI. All rights reserved
 * @Document("html")
 */
class MarkdownContentRenderer {
    public function render($content){
        return str_replace('title', 'Welcome!!', $content);
    }
}
```    
    
- triggers
- syncers
- actions

#### Triggers2
- on event/hook
- on request

#### Actions
- ed