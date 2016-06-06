<!---
title: Themes
subtitle: Develop
-->

# Themes

## Introduction
Codex does not come with a full blown theme library with it's own logic. It does however have some methods to deal with it.

### Views
- All views are registered in the [`Addons`](#phpdoc:Codex\Addons\Addons) class.
- A view can be requested by using [`codex()->view($name)`](#phpdoc::Codex\Codex::view). 
- A view can be set by using [`Addons::getInstance()->view($name, $view)`](#phpdoc:Codex\Addons\Addons::view)


### Scripts, styles etc
- Add scripts by using [`codex()->theme->addScript($name, $value, $depends = [])`](#phpdoc:Codex\Theme::addScript)