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
