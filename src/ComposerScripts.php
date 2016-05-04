<?php
namespace Codex\Core;
use Composer\Script\Event;
use Illuminate\Foundation\Application;

class ComposerScripts
{
    /**
     * Handle the post-install Composer event.
     *
     * @param  \Composer\Script\Event  $event
     * @return void
     */
    public static function eventHandler(Event $event)
    {
       # $event->getComposer()->getPluginManager()->loadInstalledPlugins();
        foreach($event->getComposer()->getRepositoryManager()->getLocalRepository()->getPackages() as $package){

            if($package->getType() === 'codex-addon'){

                $a = 'a';
            }
        }
    }



    /**
     * Clear the cached Laravel bootstrapping files.
     *
     * @return void
     */
    protected static function clearCompiled()
    {
        $laravel = new Application(getcwd());

        if (file_exists($compiledPath = $laravel->getCachedCompilePath())) {
            @unlink($compiledPath);
        }

        if (file_exists($servicesPath = $laravel->getCachedServicesPath())) {
            @unlink($servicesPath);
        }
    }
}
