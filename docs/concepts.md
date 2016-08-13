<!--
title: Concepts
-->

# Concepts

Overview of Codex concepts

## Codex

### Menus
Within Codex all menus are registered, defined, processed and rendered using the `Codex\Menus` classes. 
A central place to create and override menus. All menus, including those of addons should be created using this.
     
- `Codex\Menus\Menus`
- `Codex\Menus\Menu`
- `Codex\Menus\Node`

```php
/** @var \Codex\Menus\Menu $menu **/
$menu = codex()->menus->get('codex');
$menu = codex()->menus->add('projects')
/** @var  $root */
$root = $menu->add('codex');
$items = $root->getChildren();
```

### Projects
A project contains documentation specific for that given project.  The documentation is located in seperate 

#### Disks
Each project has a disk. 

### Refs

#### Branch

#### Version

### Documents



### Addons

#### Hooks

#### Processors

#### Plugins

#### Views

### Helpers

#### Cache

#### Theme

#### Traits

#### Extender

### Dev

### Config