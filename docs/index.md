<!---
title: Overview
subtitle: Codex Documentation
buttons:
  type: buttons
  buttons:    
    github: 
      text: Github
      icon: fa fa-github    
      attr:
          href: https://github.com/codex-project/codex
          target: _blank
    packagist:
      text: Packagist
      attr:    
          href: https://packagist.org/packages/codex
          target: _blank
-->


# Codex Documentation

<!--*codex:general:hide*-->

> Head over to [codex-project.ninja](http://codex-project.ninja) for the full documentation (starting with this document) to get started.

<!--*codex:/general:hide*-->


<!--*codex:phpdoc:method_signature('Codex\\Codex::url()')*-->

## Introduction
**Codex** is a file-based documentation platform built on top of Laravel. It's completely customizable and dead simple to use to create beautiful documentation.

Codex is able to do things like transforming markdown or automaticaly fetching documentation from a Bitbucket/Github repositories.
Most of it's features are provided by addons. Codex is extenable, themeable, hackable and simple to setup and use.

## How it works

**Codex** > **Projects** > **Refs (versions)** > **Documents** > **Processors**

- _Codex_ can provide documentation for multiple _Projects_.
- Each _Project_ has one or more _Refs (versions)_ containing your _Documents_.
- _Documents_ are passed trough _Processors_, modifying it's content before displaying.

## Features
- Laravel 5
- Markdown, Creole or custom document parsers
- Host a unlimited number of _projects/manuals_ with accompanying _versions_
- Extenable, themeable, hackable 
- Simple to setup and use
- Syntax Highlighting
- Easy navigation defined in YAML
- SEO Friendly URLs
- Default theme build on Laravels theme
- Multiple storage methods (local, dropbox, amazon, etc)
- Can be installed as stand-alone or sub-component in your own (Laravel) project.
- (Addon Feature) Github/Bitbucket (auto webhook) synchronisation based on tags/branches. 
- (Addon Feature) Smooth working, custom PHPDoc integration
- (Addon Feature) Access restriction on projects using Github/Bitbucket login
- Much, much more!

### Examples
One of Codex it's defining features is PHPDoc integration.
The `codex/addon-phpdoc` adds **links**, **macros** and even a complete API browser.
It comes down to be able to do this kind of stuff in your documentation (using popovers, hover the class names).


#### Links
Create links using `[text](#codex:phpdoc['MyNamespace\\MyClass'])`.

You can use modifiers for various extra behaviours like `[text](#codex:phpdoc['MyNamespace\\MyClass']:popover)`.

| Example | Name | Code |
|:--------|:-----|:-----|
| [`Codex`](#codex:phpdoc['Codex\\Codex']:popover) | Class popover | `#codex:phpdoc['Codex\\Codex']:popover` |
| [`get`](#codex:phpdoc['Codex\\Codex::get']:popover:signature) | Method signature popover | `#codex:phpdoc['Codex\\Codex::get']:popover:signature` |
| [`get`](#codex:phpdoc['Codex\\Codex::get']:popover) | Method popover | `#codex:phpdoc['Codex\\Codex::get']:popover` |
| [`Codex`](#codex:phpdoc['Codex\\Codex']:modal) | Class modal | `#codex:phpdoc['Codex\\Codex']:modal` |
| [`Codex`](#codex:phpdoc['Codex\\Codex']:modal:method-list) | Class method list modal | `#codex:phpdoc['Codex\\Codex']:modal:method-list` |
| [`Codex`](#codex:phpdoc['Codex\\Codex']:modal:property-list) | Class property list modal | `#codex:phpdoc['Codex\\Codex']:modal:property-list` |
| [`Codex`](#codex:phpdoc['Codex\\Codex']:modal:source) | Class source modal | `#codex:phpdoc['Codex\\Codex']:modal:source` |
| [`Codex`](#codex:phpdoc['Codex\\Codex']:modal:modal-full:app) | Class source modal | `#codex:phpdoc['Codex\\Codex']:modal:app` |
| [`get`](#codex:phpdoc['Codex\\Codex::get']:modal:signature) | Method signature modal | `#codex:phpdoc['Codex\\Codex::get']:modal:signature` |
| [`get`](#codex:phpdoc['Codex\\Codex::get']:modal) | Method modal | `#codex:phpdoc['Codex\\Codex::get']:modal` |




#### Macros
```markdown
<!--*codex:phpdoc:method:signature('Codex\\Codex::url()')*-->
```
<!--*codex:phpdoc:method:signature('Codex\\Codex::url()')*-->


```markdown
<!--*codex:phpdoc:method('Codex\\Codex::url()')*-->
```
<!--*codex:phpdoc:method('Codex\\Codex::url()')*-->


```markdown
<!--*codex:phpdoc:list:method('Codex\\Codex')*-->
```
<!--*codex:phpdoc:list:method('Codex\\Codex')*-->


```markdown
<!--*codex:phpdoc:list:property('Codex\\Codex')*-->
```
<!--*codex:phpdoc:list:property('Codex\\Codex')*-->



```markdown
<!--*codex:phpdoc:entity('Codex\\Codex')*-->
```
<!--*codex:phpdoc:entity('Codex\\Codex')*-->




### Addons
The `addon-*` packages are a collection of _Plugins_, _Hooks_ and _Processors_.



#### Plugins
Plugins are used to alter Codex. They are capable of doing something very minor or completely alter the way Codex works. 


- Adding routes/controllers
- Define custom document types
- Adding/changing views
- Adding/chaning assets
- Many more things.
- Extend the Codex API and structure with new features and functionality


#### Processors
Processors are used to alter the output of documents. 
 
- Reading document attributes
- Parsing Markdown/Creole/Anything to HTML
- Adding tooltips
- Inject HTML/Javascript
- Generate table of contents
- Altering links
- Many more things.  


#### Hooks
Hooks are able to execute when Codex executes code which have hook-points defined. This could be seen as a event dispatcher/listener.

- Allows minor or major modifications to Codex its inner workings.
- Codex is full of hook points with getters/setters to adjust class properties.
- Ensures code that doesn't have to be executed, won't be executed.


#### Example
The data is provided by the **PHPDoc Addon**. It uses the [`LinksProcessor`](#sodexxx:phpdoc:popover:Codex\Processors\LinksProcessor) 
to alter the links based on the information provided by PHPDoc Addon. 

| Example                                                          | Code                                                             |
|:-----------------------------------------------------------------|:-----------------------------------------------------------------|
| [`Codex`](../index.md#sodexxx:phpdoc:Codex\Codex)                  | `[Codex](#sodexxx:phpdoc:Codex\Codex)`                             |
| [`Codex`](https://whatever.url#sodexxx:phpdoc:popover:Codex\Codex) | `[Codex](https://whatever.url#sodexxx:phpdoc:popover:Codex\Codex)` |
| [`Codex::url`](../index.md#sodexxx:phpdoc:popover:Codex\Codex:url) | `[Codex::url](#sodexxx:phpdoc:popover:Codex\Codex:url)`            |



- More information on how to use the [`LinksProcessor`](#sodexxx:phpdoc:popover:Codex\Processors\LinksProcessor) [can be found here](develop/processors/links.md).
- More information on the PHPDoc Addon [should be here](addons/phpdoc.md).


### File Structure
A example file structure for Codex might look similar to: 
```
- docs
    - my-awesome-project
        - config.php
        - v1.0.0
            - menu.yml
            - index.md
            - contributing.md
        - v1.1.0
            - menu.yml
            - index.md
            - contributing.md
        - master
            - menu.yml
            - index.md
            - contributing.md
            - installation.md
            - configuration.md
        - develop
            - menu.yml
            - index.md
    - my-second-project
        - ...
```

