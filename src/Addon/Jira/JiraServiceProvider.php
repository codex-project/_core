<?php
namespace Codex\Addon\Jira;

use Codex\Traits\CodexProviderTrait;
use Sebwite\Support\ServiceProvider;

class JiraServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $shared = [
        'codex.jira' => Jira::class
    ];
}