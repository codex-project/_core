<?php
namespace Codex\Dev;

use Codex\Traits\CodexProviderTrait;
use Sebwite\Support\ServiceProvider;

class DevServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $middleware = [
        Middleware\CodexDev::class,
    ];

    protected $shared = [
        #Debugbar\Debugbar::class,
    ];

    /** @var Dev */
    protected $dev;


    public function boot()
    {
        $app = parent::boot();
        $this->bootMetas();
        #  $this->bootDebugbar();
        return $app;
    }

    public function register()
    {
        $this->registerDev();
        if($this->app['config']['codex.dev.enabled'] === true)
        {
            $app = parent::register();
            $this->hasIdeaMeta() && $this->app->register('Sebwite\IdeaMeta\IdeaMetaServiceProvider');
            $this->hasDebugbar() && $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }
        return $this->app;
    }

    protected function registerDev()
    {
        $this->app->instance('codex.dev', $this->dev = Dev::getInstance());
        $this->codexHook('document:render', function(){
            $this->dev->stopBenchmark(true);
        });
    }

    protected function hasIdeaMeta()
    {
        return class_exists('Sebwite\IdeaMeta\IdeaMetaServiceProvider') || $this->app->bound('idea-meta');
    }

    public function hasDebugbar()
    {
        return class_exists('Barryvdh\Debugbar\ServiceProvider') || $this->app->bound('debugbar');
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

    public function bootMenus()
    {
        $menus = $this->codex()->menus;
        $menu  = $menus->add('dev');
        $menu->add('dev-log', 'Log')->setAttribute('href', route('codex.dev.log'));
    }
}
