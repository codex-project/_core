<?php
namespace Codex\Dev;

use Sebwite\Support\ServiceProvider;

class DevServiceProvider extends ServiceProvider
{
    protected $providers = [
        \Sebwite\IdeaMeta\IdeaMetaServiceProvider::class,
        \Barryvdh\Debugbar\ServiceProvider::class,
    ];

    protected $middleware = [
        Middleware\CodexDev::class,
    ];

    protected $shared = [
        Debugbar\Debugbar::class,
    ];


    public function boot()
    {
        $app = parent::boot();
        $this->bootMetas();
      #  $this->bootDebugbar();
        return $app;
    }

    protected function bootMetas()
    {
        if ( $this->app->bound('idea-meta') )
        {
            $this->app[ 'idea-meta' ]->add('codex', Metas\CodexMeta::class);
            $this->app[ 'idea-meta' ]->add('codex-projects', Metas\CodexProjectsMeta::class);
        }
    }

    protected function bootDebugbar()
    {

        if ( $this->app->bound('debugbar') )
        {
            $db = $this->app->make('debugbar');
            #$db->getJavascriptRenderer()->addControl('asdf', [])
            $db->getJavascriptRenderer()->addAssets([
                #    __DIR__ . '/../resources/assets/codex-widget.css'
            ], [
                __DIR__ . '/../resources/dev/assets/codex-debugbar.js',
            ]);
            $dbr = app(Debugbar\Debugbar::class);
            $dbr->add('general', 'General')
                ->icon('bullhorn')
                ->iconColor('blue')
                ->value('Welcome')
                ->active(true);

            $dbr->add('project', 'Project')
                ->icon('code-fork')
                ->iconColor('dark-orange')
                ->type('code')
                ->language('php')
                ->value(
                    '<?php return ' . var_export([
                        'asdf' => 'asdff',
                    ], true)
                );
        }

        $this->app->make('codex.addons')->hooks->hook('controller:view', function ($controller, $view, $codex, $project, $document)
        {
            if ( $this->app->bound('debugbar') )
            {
                $db = $this->app->make('debugbar');
              #  $db->addCollector(new Debugbar\CodexCollector($controller, $view, $codex, $project, $document));
            }
        });
    }
}
