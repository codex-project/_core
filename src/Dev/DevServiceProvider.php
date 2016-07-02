<?php
namespace Codex\Dev;

use Codex\Codex;
use Codex\Dev\Debugbar\CodexSimpleCollector;
use Codex\Documents\Document;
use Codex\Http\Controllers\CodexController;
use Codex\Projects\Project;
use Codex\Traits\CodexProviderTrait;
use Sebwite\Support\ServiceProvider;

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
        if ( class_exists('Sebwite\IdeaMeta\IdeaMetaServiceProvider') && $this->app->bound('idea-meta') === false )
        {
            $this->app->register('Sebwite\IdeaMeta\IdeaMetaServiceProvider');
        }
    }

    protected function registerDebugbar()
    {
        if ( class_exists('Barryvdh\Debugbar\ServiceProvider') && $this->app->bound('idea-meta') === false )
        {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }
    }

    protected function registerDev()
    {
        $this->app->instance('codex.dev', $this->dev = Dev::getInstance());

        $this->codexHook('document:render', function ()
        {
            $this->dev->stopBenchmark(true);
        });
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
            $this->app->make('debugbar')->addCollector($collector = $this->app->make('codex.dev.debugbar.collector'));
            $this->codexHook('controller:document', function (CodexController $controller, Document $document) //, Codex $codex, Project $project
            {
                /** @var CodexSimpleCollector $collector */
                $collector = $this->app->make('debugbar')->getCollector('codex');
                $collector->setDocument($document);
                $collector->data()->set('document', $document->toArray());
                $collector->data()->set('hookPoints', \Codex\Codex::$hookPoints);
                $hooks = [ ];
                foreach ( $this->codexAddons()->hooks->all() as $hook )
                {
                    $hooks[] = [ 'name' => $hook[ 'name' ], 'class' => $hook[ 'class' ], 'listener' => $hook[ 'listener' ] ];
                }
                $collector->data()->set('hooks', $hooks);
            });
        }
        return;
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
    }

    protected function bootMenus()
    {
        $menus = $this->codex()->menus;
        $menu  = $menus->add('dev');
        $menu->add('dev-log', 'Log')->setAttribute('href', '#'); //route('codex.dev.log'));
    }
}
