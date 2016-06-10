<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/10/16
 * Time: 11:25 PM
 */

namespace Codex;


use Illuminate\Contracts\Foundation\Application;

class Bootstrapper
{
    public function bootstrap(Application $app)
    {
        $app->instance('codex.addons', $addons = Addons\Addons::getInstance());
        $addons->setManifestPath($app[ 'config' ][ 'codex.paths.manifest' ]);
        $addons->registerInPath(__DIR__ . '/Addons/Filters');
        $addons->findAndRegisterAll();
    }
}
