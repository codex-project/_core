<?php
namespace Codex\Core\Addons;

use Codex\Core\Addons\Scanner\ClassFileInfo;
use Codex\Core\Support\Collection;

class Provided
{
    public $name;

    public $annotaiton;

    public $class;

    public $file;

    public $annotation;

    public function __construct($name, $annotationClass, ClassFileInfo $file)
    {
        $this->name       = $name;
        $this->annotaiton = $annotationClass;
        $this->class      = $file->getClassName();
        $this->file       = $file->getFilename();
        $this->annotation = Collection::make([
            'class'      => $file->getClassAnnotations(),
            'method'     => $file->getMethodAnnotations(),
            'properties' => $file->getPropertyAnnotations(),
        ]);
    }


}
