<?php
namespace Codex\Dev;

use Codex\Dev\Debugbar\CodexSimpleCollector;
use Codex\Documents\Document;
use Codex\Http\Controllers\CodexController;
use Codex\Support\Traits\CodexProviderTrait;
use Laradic\ServiceProvider\ServiceProvider;

class DevServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $middleware = [
        Middleware\CodexDev::class,
    ];

    protected $shared = [
        'codex.dev.debugbar.collector' => Debugbar\CodexSimpleCollector::class,
    ];

    /** @var Dev */
    protected $dev;


    protected function isEnabled($devkey)
    {

        return
            $this->app[ 'config' ]->get('codex.dev.enabled', false) === true &&
            $this->app[ 'config' ]->get('codex.dev.' . $devkey, false) === true;
    }

    public function boot()
    {
        $app = parent::boot();
        $this->isEnabled('metas') && $this->bootMetas();
        $this->isEnabled('debugbar') && $this->bootDebugbar();
        $this->bootMenus();
        return $app;
    }

    public function register()
    {
        $app = parent::register();
        $this->registerDev();
        $this->isEnabled('metas') && $this->registerMetas();
        $this->isEnabled('debugbar') && $this->registerDebugbar();
        return $app;
    }

    protected function registerMetas()
    {
        if ( class_exists('Laradic\\Phpstorm\\Autocomplete\\AutocompleteServiceProvider') && $this->app->bound('idea-meta') === false ) {
            $this->app->register('Laradic\\Phpstorm\\Autocomplete\\AutocompleteServiceProvider');
        }
    }

    protected function registerDebugbar()
    {
        if ( class_exists('Barryvdh\Debugbar\ServiceProvider') && $this->app->bound('debugbar') === false ) {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }
    }

    protected function registerDev()
    {
        $this->app->instance('codex.dev', $this->dev = Dev::getInstance());

        $this->codexHook('document:render', function () {
            $this->dev->stopBenchmark(true);
        });

        $this->codexIgnoreRoute('dev');
    }

    protected function bootMetas()
    {
        if ( $this->app->bound('idea-meta') ) {
            $this->app[ 'idea-meta' ]->add('codex', Metas\CodexMeta::class);
            $this->app[ 'idea-meta' ]->add('codex-projects', Metas\CodexProjectsMeta::class);
        }
    }

    protected function bootDebugbar()
    {

        if ( $this->app->bound('debugbar') ) {
            $this->app->make('debugbar')->addCollector($collector = $this->app->make('codex.dev.debugbar.collector'));
            $this->codexHook('controller:document', function (CodexController $controller, Document $document) //, Codex $codex, Project $project
            {
                /** @var CodexSimpleCollector $collector */
                $collector = $this->app->make('debugbar')->getCollector('codex');
                $collector->setDocument($document);
                $collector->data()->set('document', $document->toArray());
                $collector->data()->set('hookPoints', \Codex\Codex::$hookPoints);
                $collector->data()->set('views', $this->codexAddons()->views->toArray());
                $hooks = [ ];
                foreach ( $this->codexAddons()->hooks->all() as $hook ) {
                    $hooks[] = [ 'name' => $hook[ 'name' ], 'class' => $hook[ 'class' ], 'listener' => $hook[ 'listener' ] ];
                }
                $collector->data()->set('hooks', $hooks);
            });
        }
        return;
        if ( $this->app->bound('debugbar') ) {
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
    }

    protected function bootMenus()
    {
        $this->codexView('menus.dev', 'codex::menus.header-dropdown');

        $menu  = $this->codex()->menus->add('dev', [ 'title' => 'Dev' ]);

        $menu->add('dev-log', 'Log')->setAttribute('href', '#'); //route('codex.dev.log'));
        $this->codex()->theme->pushContentToStack('nav', $this->codexView('layout'), function ($view) use ($menu) {
            return $menu->render();
        });
    }
}
