<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Annotations\Filter;
use Codex\Core\Addons\Scanner\ClassFileInfo;

class FilterAddons extends AbstractAddonCollection
{
    public function add(ClassFileInfo $file, Filter $annotation)
    {
        $class = $file->getClassName();
        $data  = array_merge(compact('file', 'annotation', 'class'), (array)$annotation);
        $this->set($class, $data);

        // could be that it should be added later
        if ( $annotation->replace !== false ) {
            $this->forget($annotation->replace);
        }
    }

    public function getFilter($name)
    {
        $filter = $this->where('name', $name)->first();
        return $filter;
    }
}