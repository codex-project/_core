<!---
title: Overview
author: Robin Radic
icon: fa fa-eye
-->

| Point | Where | Params | Description |
|:------|:------|:------|:------------|
| `factory:ready` | `Factory::__construct` | `Factory` | Called when the constructor parameters are assigned as class properties |
| `factory:done` | `Factory::__construct` | `Factory` | Called after the factory has resolved all projects |
| `project:ready` | `Project::__construct` | `Project` | Called when the constructor parameters are assigned as class properties |
| `project:done` | `Project::__construct` | `Project` | Called after the project has scanned all versions/refs in the project |
| `project:make` | `Factory::resolveProjects` | `Factory, Project` | Called after a `Project` been resolved |
| `project:document` | `Project::getDocument` | `Document` | Called after the `Document` has been resolved |
| `project:documents-menu` | `Project::getDocumentsMenu` | `Project`, `Menu` | After the menu hasbeen resolved |
| `document:ready` | `Document::__construct` | `Document` | Called when the constructor parameters are assigned as class properties |
| `document:done` | `Document::__construct` | `Document` | Called after the document has resolved the raw content |
| `document:render` | `Document::render` | `Document` | Called before the document is rendered |
| `menu-factory:ready` | `MenuFactory::__construct` | `Factory` | Called when the constructor parameters are assigned as class properties |
| `menu-factory:add` | `MenuFactory::add` | `MenuFactory, Menu` |   |
| `menu-factory:forget` | `MenuFactory::forget` | `MenuFactory, $id` |   |
| `menu:ready` | `Menu::__construct` | `Menu` | Called when the constructor parameters are assigned as class properties |
| `menu:done` | `Menu::__construct` | `Menu` | Called after the `Menu` root node has been created |
