<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/11/16
 * Time: 5:52 AM
 */

namespace Codex\Addons\Filters\Buttons;


use ArrayAccess;
use Codex\Support\Extendable;
use Codex\Traits\ArrayableAccess;
use Codex\Traits\AttributesTrait;
use Illuminate\Contracts\Support\Arrayable;

class Button extends Extendable implements Arrayable, ArrayAccess
{
    use AttributesTrait,
        ArrayableAccess;

    protected $text;

    protected $id;

    /**
     * @var null
     */
    protected $groupId;

    /**
     * DocumentButton constructor.
     *
     * @param string $id
     * @param string $text
     * @param array  $attr
     */
    public function __construct($id, $text, array $attr = [ ], $groupId = null)
    {
        $this->id      = $id;
        $this->text    = $text;
        $this->groupId = $groupId;

        $this->setAttributes($attr);
    }

    public function render()
    {
        $html = '<a';

        if ( ! isset($this->attributes[ 'class' ]) ) {
            $this->attributes[ 'class' ] = '';
        }
        $this->attributes[ 'class' ] .= ' btn btn-primary';

        foreach ( $this->attributes as $key => $val ) {
            $html .= " {$key}=\"{$val}\"";
        }

        $html .= '>' . $this->text . '</a>';

        return $html;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     *
     * @return Button
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param null $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    public function hasGroup()
    {
        return $this->groupId !== null;
    }


    public function toArray()
    {
        return [
            'id'         => $this->id,
            'groupId'    => $this->groupId,
            'text'       => $this->text,
            'attributes' => $this->attributes,
        ];
    }
}
