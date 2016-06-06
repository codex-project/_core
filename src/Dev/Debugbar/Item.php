<?php
namespace Codex\Dev\Debugbar;


use Illuminate\Support\Fluent;

/**
 * This is the class DebugbarItem.
 *
 * @package        Codex\Dev
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @method Item icon(string $icon)
 * @method Item iconColor(string $color)
 * @method Item type(string $type)
 * @method Item language(string $codeLanguage)
 * @method Item value(string $value)
 * @method Item active(bool $active)
 */
class Item extends Fluent
{
    protected $id;

    protected $name;

    protected $debugBar;

    /**
     * DebugbarItem constructor.
     *
     * @param \Codex\Dev\Debugbar\DebugBar $debugBar
     * @param                              $id
     * @param                              $name
     */
    public function __construct(DebugBar $debugBar, $id, $name)
    {
        $this->debugBar = $debugBar;
        $this->id       = $id;
        parent::__construct([
            'id'   => $id,
            'name' => $name,
            'type' => 'text'
        ]);
    }
}

class BaseWidget extends Fluent {
    protected $id;

    /**
     * BaseWidget constructor.
     *
     * @param $id
     */
    public function __construct($id, $attr = [])
    {
        parent::__construct($attr);
        $this->id = $id;
    }

}
class Tabs extends BaseWidget {
    public function add($id)
    {

    }
}
class Tab extends BaseWidget {

}
class Content extends BaseWidget {

}