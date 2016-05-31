<!---
title: Overview
subtitle: Codex Documentation   
-->

Codex can be considered as a documentation reading application. Though, you'll notice it does quite a few things more then simply showing it.
It can do things like transforming markdown or fetching documentation from a Bitbucket/Github repository whenever you push and much more.
Most of it's features are provided by addons. Codex is extenable, themeable, hackable and simple to setup and use.


## Laravel
[Codex](#phpdoc:Codex\Core\Codex) is a PHP application based on Laravel 5 and can be installed as stand-alone or sub-component in your own (Laravel) project.
[CodexController](#phpdoc:Codex\Core\Http\Controllers\CodexController)

## Addon based
As previously mentioned, most of the features are provided by Addons. This makes Codex capable of doing anything you'd like. Here's a few to give you a better picture:

| Name     | Description                                                                                                |
|:---------|:-----------------------------------------------------------------------------------------------------------|
| Markdown | Enables Markdown support. It can use any Markdown PHP library using a simple interface                     |
| Git      | Make a project pull it's documentation from Github or Bitbucket. Manually or automatically using a webhook |
| Phpdoc   | Integrate PHPDoc into your project.                                                                        |


## How it works

#### Flow
**Codex** > **Projects** > **Versions** > **Documents** > **Filters**

- Codex can provide documentation for multiple projects. 
- Each project has one or more versions containing your documents. 
- Documents are passed trough filters, modifying it's content before displaying.

To give you an understanding of filters, lets take the ToC filter as example. It takes all headings in a document and generates a table of content at the start ([example](#)).

#### Configurable
- Codex has many configurable settings to alter the overall working of the application.
- Each project has individual configuration using the `config.php`
- Documents can be configured using Frontmatter or similar attribute configuration methods.  
- Each filter can be configured both in the project configuration or document attributes.


#### Structure
###### Files
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

