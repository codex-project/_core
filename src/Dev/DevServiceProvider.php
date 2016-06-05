<?php
namespace Codex\Dev;

use Sebwite\Support\ServiceProvider;

class DevServiceProvider extends ServiceProvider
{
    protected $providers = [
        \Sebwite\IdeaMeta\IdeaMetaServiceProvider::class,
        \Barryvdh\Debugbar\ServiceProvider::class,
    ];

    public function boot()
    {
        $app = parent::boot();
        $this->registerMetas();
        return $app;
    }

    protected function registerMetas()
    {
        if ( $this->app->bound('idea-meta') )
        {
            $this->app[ 'idea-meta' ]->add('codex', Metas\CodexMeta::class);
            $this->app[ 'idea-meta' ]->add('codex-projects', Metas\CodexProjectsMeta::class);
        }
    }
}