<!--
title: Overview
subtitle: Develop
-->

# Overview

## Extendable
Most classes extend [`Support\Extendable`](#codex:phpdoc:popover:Codex\Support\Extendable). It combines a few traits and interfaces to facilitate hook-points and dynamic extensions.

[`Codex`](#codex:phpdoc:popover:Codex\Codex)

[`Codex->projects`](#codex:phpdoc:popover:Codex\Codex) -> [`Projects\Projects`](#codex:phpdoc:popover:Codex\Projects\Projects)

[`Projects\Projects::get()`](#codex:phpdoc:popover:Codex\Projects\Projects::get) -> [`Projects\Project`](#codex:phpdoc:popover:Codex\Projects\Project)



|                      Class overview                      |  |                                                                      |                                                                          |
|:--------------------------------------------------------:|:--|:--------------------------------------------------------------------:|:------------------------------------------------------------------------:|
|       [`Codex`](#codex:phpdoc:popover:Codex\Codex)       | >> | [`Projects\Projects`](#codex:phpdoc:popover:Codex\Projects\Projects) | [`Documents\Documents`](#codex:phpdoc:popover:Codex\Documents\Documents) |
|                                                          |  |  [`Projects\Project`](#codex:phpdoc:popover:Codex\Projects\Project)  |  [`Documents\Document`](#codex:phpdoc:popover:Codex\Documents\Document)  |
| [`Menus\Menus`](#codex:phpdoc:popover:Codex\Menus\Menus) |  |                                                                      |                                                                          |
|                                                          |  |                                                                      |                                                                          |
|  [`Menus\Menu`](#codex:phpdoc:popover:Codex\Menus\Menu)  |  |                                                                      |                                                                          |
|  [`Menus\Node`](#codex:phpdoc:popover:Codex\Menus\Node)  |  |                                                                      |                                                                          |






- [`Codex`](#codex:phpdoc:popover:Codex\Codex)
- [`Projects\Projects`](#codex:phpdoc:popover:Codex\Projects\Projects)
- [`Projects\Project`](#codex:phpdoc:popover:Codex\Projects\Project)
- [`Menus\Menus`](#codex:phpdoc:popover:Codex\Menus\Menus)
- [`Menus\Menu`](#codex:phpdoc:popover:Codex\Menus\Menu)
- [`Menus\Node`](#codex:phpdoc:popover:Codex\Menus\Node)
- [`Documents\Documents`](#codex:phpdoc:popover:Codex\Documents\Documents)
- [`Documents\Document`](#codex:phpdoc:popover:Codex\Documents\Document)


[`Codex`](#codex:phpdoc:popover:Codex\Codex) is the main class. Can be accessed with `codex()`. [`Codex`](#codex:phpdoc:popover:Codex\Codex) extends [`Support\Extendable`](#codex:phpdoc:popover:Codex\Support\Extendable) which is a collection of traits and interfaces providing all sorts of utility. 