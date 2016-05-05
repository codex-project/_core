<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Annotations\Hook;
use Codex\Core\Addons\Scanner\ClassFileInfo;

class HookAddons extends AbstractAddonCollection
{


    /**
     * add method
     *
     * @param \Codex\Core\Addons\Scanner\ClassFileInfo $file
     * @param                                          $annotation
     * @param string|null                              $method
     */
    public function add(ClassFileInfo $file, Hook $annotation, $method = null)
    {
        $class = $file->getClassName();

        $id       = $method === null ? $class : "{$class}@{$method}";
        $listener = $id;
        $this->set($id, array_merge(compact('file', 'annotation', 'class', 'listener'), (array)$annotation));

        if ( $annotation->replace ) {
            $this->set("{$annotation->replace}.replaced", $id);
        }

        $hooks = $this;
        $this->app->make('events')->listen('codex:' . $annotation->name, function () use ($hooks, $id) {
            if ( $hooks->has("{$id}.replaced") ) {
                return;
            }
            $listener = $this->app->build($hooks->get("{$id}.listener"));
            call_user_func_array([ $listener, 'handle' ], func_get_args());
        });
    }

    public function hook($name, $hook)
    {
        $this->app->make('events')->listen("codex:{$name}", $hook);
        return $this;
    }

}