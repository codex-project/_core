<?php
namespace Codex\Core\Addons;


class DefaultsAddons extends AbstractAddonCollection
{


    public function addProperty($file, $annotation, $property)
    {
        $this->set('');
    }

    public function addMethod($file, $annotation, $method)
    {
    }
}