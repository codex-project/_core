<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Scanner\ClassFileInfo;
use Codex\Core\Documents\Document;
use Codex\Core\Exception\CodexException;

class ThemeAddons extends AbstractAddonCollection
{
    public function __construct(array $items, $addons = null)
    {
        parent::__construct($items, $addons);
    }

    protected $active;

    public function add(ClassFileInfo $file, $annotation)
    {
        $theme = app()->build($class = $file->getClassName());
        $provider = $this->createProvider($file, $theme);
        $views = [];
        $data             = array_merge(compact('views', 'provider', 'theme', 'file', 'class'), (array)$annotation);
        $data[ 'active' ] = false;
        $this->set($annotation->name, $data);
    }


    protected function activateTheme($name)
    {
        $data = $this->get($name);
        $this->app->register($data[ 'provider' ]);

        if ( method_exists($data[ 'theme' ], $data['method']) ) {
            $views = call_user_func([$data['theme'], $data['method']]);
            $this->set("{$name}.views", $views);
        }
        $this->set("{$name}.active", true);
        $this->active = $name;
        return $data;
    }

    public function getActive()
    {
        return $this->get($this->active);
    }

    public function hookTheme()
    {
        $this->addons->hooks->hook('document:render', function(Document $document){
            $name  = codex()->config('theme', 'default');
            $this->activateTheme($name);
            $active = $this->getActive();
            $document->setAttribute('views.layout', $active->get('views.layout', $document->attr('views.layout')));
            $document->setAttribute('views.document', $active->get('views.document', $document->attr('views.document')));
            $menus = $document->getCodex()->menus;
            foreach($active->get('views.menus', []) as $id => $view){
                $menus->has($id) && $menus->get($id)->setView($view);
            }
        });
    }



}