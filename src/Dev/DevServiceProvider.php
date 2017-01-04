<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Dev;

use Barryvdh\Debugbar\DataCollector\LogsCollector;
use Codex\Codex;
use Codex\Dev\Debugbar\CodexSimpleCollector;
use Codex\Documents\Document;
use Codex\Http\Controllers\CodexDocumentController;
use Codex\Support\Traits\CodexProviderTrait;
use DebugBar\Bridge\MonologCollector;
use Illuminate\Foundation\Application;
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


    protected function isEnabled()
    {
        return $this->config->get('codex.dev', false) === true;
    }

    public function boot()
    {
        if ($this->isEnabled()) {
            $app = parent::boot();
            $this->bootMetas();
            $this->bootDebugbar();
//            $this->bootMenus();
            return $app;
        }
        return $this->app;
    }

    public function register()
    {
        $this->registerDev();
        Codex::extend('dev', 'codex.dev');
        if ($this->isEnabled()) {
            $app = parent::register();
            $this->registerMetas();
            $this->registerDebugbar();
            return $app;
        }
        return $this->app;
    }

    protected function registerMetas()
    {
        if (class_exists('Laradic\Idea\IdeaServiceProvider') && $this->app->bound('idea-meta') === false) {
            $this->app->register('Laradic\Idea\IdeaServiceProvider');
        }
    }

    protected function registerDebugbar()
    {
        if (class_exists('Barryvdh\Debugbar\ServiceProvider') && $this->app->bound('debugbar') === false) {
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
        if ($this->app->bound('laradic.idea.meta')) {
            $this->app[ 'laradic.idea.meta' ]->add('codex', Metas\CodexMeta::class);
            $this->app[ 'laradic.idea.meta' ]->add('codex-projects', Metas\CodexProjectsMeta::class);
        }
    }

    protected function bootDebugbar()
    {

        if ($this->app->bound('debugbar')) {
            $db = $this->app->make('debugbar');
            $db->addCollector($codexCollector = $this->app->make('codex.dev.debugbar.collector'));
            $db->addCollector($logsCollector = new Debugbar\CodexLogsCollector(config('codex.paths.log', ''), 'codexLogs'));

            $this->codexHook('controller:document', function (CodexDocumentController $controller, Document $document) use ($db) {
 //, Codex $codex, Project $project
                /** @var CodexSimpleCollector $collector */
                $collector = $db->getCollector('codex');
                $collector->setDocument($document);
                $collector->data()->set('document', $document->toArray());
                $collector->data()->set('hookPoints', \Codex\Codex::$hookPoints);
                $collector->data()->set('views', $this->codexAddons()->views->toArray());
                $hooks = [];
                foreach ($this->codexAddons()->hooks->all() as $hook) {
                    $hooks[] = [ 'name' => $hook[ 'name' ], 'class' => $hook[ 'class' ], 'listener' => $hook[ 'listener' ] ];
                }
                $collector->data()->set('hooks', $hooks);
            });
        }
    }

    protected function bootMenus()
    {
        $this->codexView('menus.dev', 'codex::menus.header-dropdown');

        $menu = $this->codex()->menus->add('dev', [ 'title' => 'Dev' ]);

        $menu->add('dev-log', 'Log')->setAttribute('href', '#'); //route('codex.dev.log'));
        $this->codex()->theme->pushContentToStack('nav', $this->codexView('layout'), function ($view) use ($menu) {
            return $menu->render();
        });
    }
}
