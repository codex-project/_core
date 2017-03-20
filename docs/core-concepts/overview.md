<!--
title: Overview
subtitle: Core Concepts
-->
# Overview

**Codex** > **Projects** > **Refs (versions)** > **Documents** > **Processors**

- [_Codex_](#codex:phpdoc['Codex\\Codex']:popover:type[false]) can provide documentation for multiple _Projects_.
- Each _Project_ has one or more _Refs (versions)_ containing your _Documents_.
- _Documents_ are passed trough _Processors_, modifying it's content before displaying.


## Configuration

<!--*codex:phpdoc:method:signature('Codex\Codex::view()')*-->


#### Plugins
Plugins are used to alter Codex. They are capable of doing something very minor or completely alter the way Codex works. 


- Adding routes/controllers
- Define custom document types
- Adding/changing views
- Adding/chaning assets
- Many more things.
- Extend the Codex API and structure with new features and functionality


#### Processors
Processors are used to alter the output of documents. A few examples
 
- [AttributesProcessor](#codex:phpdoc['Codex\\Processors\\AttributesProcessor']:popover:type[false]) for document attributes
- [ParserProcessor](#codex:phpdoc['Codex\\Processors\\ParserProcessor']:popover:type[false]) for parsing Markdown/Creole/Anything to HTML
- [TocProcessor](#codex:phpdoc['Codex\\Processors\\TocProcessor']:popover:type[false]) for generate table of contents
- [LinksProcessor](#codex:phpdoc['Codex\\Processors\\LinksProcessor']:popover:type[false]) for fixing links and providing the Codex custom links functionality. 
- Many more...  


#### Hooks
Hooks are able to execute when Codex executes code which have hook-points defined. This could be seen as a event dispatcher/listener.

- Allows minor or major modifications to Codex its inner workings.
- Codex is full of hook points with getters/setters to adjust class properties.
- Ensures code that doesn't have to be executed, won't be executed.

