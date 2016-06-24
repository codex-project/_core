<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/11/16
 * Time: 5:52 AM
 */

namespace Codex\Processors\Buttons;


use ArrayAccess;
use Codex\Support\Extendable;
use Codex\Traits\ArrayableAccess;
use Codex\Traits\AttributesTrait;
use Codex\Traits\CreateDomElementTrait;
use Illuminate\Contracts\Support\Arrayable;
use Sebwite\Support\Arr;

class Button extends Extendable implements Arrayable, ArrayAccess
{
    use AttributesTrait,
        ArrayableAccess,
        CreateDomElementTrait;

    /** @var string  */
    protected $text;

    /** @var string  */
    protected $id;

    /** @var null|string  */
    protected $groupId;

    /**
     * DocumentButton constructor.
     *
     * @param string      $id
     * @param string      $text
     * @param array       $attrs
     * @param null|string $groupId
     */
    public function __construct($id, $text, array $attrs = [ ], $groupId = null)
    {
        $this->id      = $id;
        $this->text    = $text;
        $this->groupId = $groupId;
        unset($attrs['text']);
        $this->setAttributes($attrs);
    }

    public function render()
    {
        $el = $this->createElement('a', $this->attributes);
        $el->setAttribute('class', $el->getAttribute('class') . ' btn btn-primary');
        $el->textContent = $this->text;
        return $el->saveHtml();
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
