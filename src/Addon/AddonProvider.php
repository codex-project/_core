<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addon;


use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\ServiceProvider;

abstract class AddonProvider extends ServiceProvider
{

    protected $hooks = [ ];

    protected $extensions = [ ];

    abstract public function getSlug();

    protected function extend($name, $class)
    {
        $this->extensions[] = compact('name', 'class');
    }

    public function boot(Dispatcher $events)
    {
        $app = parent::boot();
        foreach ( $this->hooks as $event => $listeners ) {
            foreach ( (array) $listeners as $listener ) {
                $events->listen("codex.{$event}", $listener);
            }
        }
        return $app;
    }

    public function register()
    {
        $app = parent::register();
        $app->booting(function(Application $app){
            //$app->make('codex')->

        });


        return $app;
    }

    public function listens()
    {
        return $this->hooks;
    }
}
