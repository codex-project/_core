<!--
title: Configuration
subtitle: Getting Started
-->
# Configuration

## Introduction
To get started, you need to configure some things in your Laravel application.

## Queues
Codex prefers you to have a working queue configuration.
This means a working queue driver and something that runs the queue, like Supervisor.
Check the official Laravel [queues documentation](https://laravel.com/docs/5.3/queues) for more information

## Caching
Because Codex caches quite a bit of data consider using a better performing cache driver instead of the default `file` driver.
