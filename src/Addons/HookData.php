<?php
namespace Codex\Core\Addons;

class HookData
{
    public $name;

    public $args = [];

    public function __construct($name, array $args = [ ])
    {
        $this->name = $name;
        $this->args = $args;
    }

    public function __get($name)
    {
        return $this->args[$name];
    }

    public function __set($name, $value)
    {
        $this->args[$name] = $value;
    }


}
