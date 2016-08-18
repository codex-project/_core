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
use Codex\Support\Traits\ArrayableAccess;
use Codex\Support\Traits\AttributesTrait;
use Codex\Support\Traits\CreateDomElementTrait;
use Illuminate\Contracts\Support\Arrayable;

class Button extends Extendable implements Arrayable, ArrayAccess
{
    use AttributesTrait,
        ArrayableAccess,
        CreateDomElementTrait;

    protected $data;

    /** @var string */
    protected $id;

    /** @var null|string */
    protected $groupId;

    /**
     * Button constructor.
     *
     * @param       $id
     * @param array $data
     * @param null  $groupId
     */
    public function __construct($id, array $data, $groupId = null)
    {
        $this->id = $id;

        $this->setAttributes([ ]);

        if ( isset($data[ 'attr' ]) )
        {
            $this->setAttributes($data[ 'attr' ]);
            unset($data[ 'attr' ]);
        }

        $data[ 'id' ]      = $id;
        $data[ 'groupId' ] = $groupId;
        $this->data        = $data;
    }

    public function render()
    {
        $el = $this->createElement('a', $this->getAttributes());
        $el->setAttribute('class', $el->getAttribute('class') . ' btn btn-primary');
        $el->textContent = $this[ 'text' ];

        $this->has('icon') && $this->createElement('i', [ 'class' => $this[ 'icon' ] ])->appendToParentNode($el);


        return $el->saveHtml();
    }

    public function has($k)
    {
        return isset($this[ $k ]);
    }

    public function get($k, $d = null)
    {
        return data_get($this->data, $k, $d);
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this[ 'text' ];
    }

    /**
     * @param mixed $text
     *
     * @return Button
     */
    public function setText($text)
    {
        $this[ 'text' ] = $text;
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
        return array_merge($this->data, [ 'attr' => $this->getAttributes() ]);
    }
}
