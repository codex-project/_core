<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Scanner\ClassFileInfo;
use Codex\Core\Exception\CodexException;

class ThemeAddons extends AbstractAddonCollection
{
    public function __construct(array $items, $addons = null)
    {
        parent::__construct($items, $addons);
    }


    public function add(ClassFileInfo $file, $annotation)
    {
        $theme = app()->build($class = $file->getClassName());
        /** @noinspection PhpParamsInspection */
        $provider = new AddonServiceProvider($this->app);
        $path     = $file->getPath();

        for ( $current = 0; $current < 4; $current++ ) {
            if ( $this->addons->getFs()->exists(path_join($path, 'composer.json')) ) {
                break;
            }
            $path = path_get_directory($path);
        }

        if ( $path === $file->getPath() ) {
            throw CodexException::because('Could not resolve root dir');
        }

        $provider->setRootDir($path);

        if ( property_exists($theme, 'config') ) {
            $provider->setConfigFiles((array)$theme->config);
        }

        if ( property_exists($theme, 'assets') ) {
            $provider->setAssetDirs((array)$theme->assets);
        }

        if ( property_exists($theme, 'views') ) {
            $provider->setViewDirs((array)$theme->views);
        }

        $data             = array_merge(compact('provider', 'theme', 'file', 'class'), (array)$annotation);
        $data[ 'active' ] = false;
        $this->set($annotation->name, $data);
    }


    protected function activateTheme($name)
    {
        $data = $this->get($name);
        $this->app->register($data[ 'provider' ]);

        if ( method_exists($data[ 'theme' ], 'getViews') ) {
            $this->set("{$name}.views", $data[ 'theme' ]->getViews());
        }
        $this->set("{$name}.active", true);
    }

    public function hookTheme()
    {
        $this->addons->hooks()->hook('menus:add', function ($menus, $id, $menu) {
            $name = codex()->config('theme', 'laravel');
            $view = $this->get("{$name}.views.menus.{$id}", null);
            if ( $view ) {
                $menu->setView($view);
            }
        });

        app()->booting(function ($app) {
            $name = codex()->config('theme', 'default');
            $this->activateTheme($name);
        });

        app()->booted(function ($app) {
            $name  = codex()->config('theme', 'default');
            $views = [ 'layout', 'view' ];
            foreach ( $views as $view ) {
                $viewFile = $this->get("{$name}.views.{$view}", null);
                if ( $view ) {
                    codex()->mergeDefaultDocumentAttributes([ $view => $viewFile ]);
                }
            }
        });
    }



}