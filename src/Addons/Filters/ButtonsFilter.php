<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/11/16
 * Time: 6:21 AM
 */

namespace Codex\Addons\Filters;

use Codex\Addons\Annotations\Filter;
use Codex\Documents\Document;
use Codex\Addons\Filters\Buttons\Button;
use Codex\Support\Collection;
use Sebwite\Support\Arr;

/**
 * Class ButtonsFilter
 *
 * @Filter("buttons", config="config", after={"parser", "toc", "header"})
 * @package Codex\Addons\Filters
 */
class ButtonsFilter
{
    /** @var \Codex\Support\Collection */
    public $config = [
        'type'          => 'groups',
        'groups'        => [
//            'group-id' => [
//                'button-id' => [
//                    'text'   => 'Haai',
//                    'href'   => 'http://goto.com/this',
//                    'target' => '_blank',
//                ],
//            ]
        ],
        'buttons'       => [
//            'button-id' => [
//                'text'   => 'Haai',
//                'href'   => 'http://goto.com/this',
//                'target' => '_blank',
//            ],
        ],
        'wrapper_class' => 'top-buttons',
    ];

    /** @var Document */
    public $document;

    /** @var Collection */
    protected $buttons;

    protected function button($id, $text, $attr = [ ], $gid = null)
    {
        $this->buttons->add(new Button($id, $text, $attr, $gid));
    }

    public function handle(Document $document)
    {
        $this->buttons = new Collection;

        $type = $document->attr('buttons.type', $this->config['type']);
        $html = call_user_func([$this, 'handle' . ucfirst($type) . 'Type']);
        $document->setContent($html . $document->getContent());

        // buttons defined on project level
//        foreach ( $this->config as $id => $button ) {
//            $this->button($id, $button[ 'text' ], $button[ 'attributes' ]);
//        }
//
//        // buttons defined on document level
//        foreach ( $document->attr('buttons', [ ]) as $id => $button ) {
//            $this->button($id, $button[ 'text' ], $button[ 'attributes' ]);
//        }
//
//        if ( count($this->buttons) > 0 ) {
//            $buttons = collect($this->buttons)->transform(function (DocumentButton $btn) {
//                return $btn->render();
//            })->implode("\n");
//            $buttons = "<div class='top-buttons'>{$buttons}</div>";
//            $document->setContent($buttons . "\n" . $document->getContent());
//        }
    }

    protected function handleGroupsType()
    {
        // buttons defined on project level
        foreach($this->config['groups'] as $gid => $buttons){
            foreach ( $buttons as $bid => $button ) {
                $this->button($bid, $button[ 'text' ], Arr::without($button, 'text'), $gid);
            }
        }

        foreach($this->document->attr('buttons.groups', []) as $gid => $buttons){
            foreach ( $buttons as $bid => $button ) {
                $this->button($bid, $button[ 'text' ], Arr::without($button, 'text'), $gid);
            }
        }

        $html = "<div class='top-buttons top-buttons-groups'>";
        $groups = $this->buttons->pluck('groupId')->unique();
        foreach($groups as $group){
            $html .= "<div class='top-button-group'>";
            foreach($this->buttons->where('groupId', $group) as $button){
                $html .= $button->render();
            }
            $html .= '</div>';
        }
        $html .= '</div>';

        return $html;
    }

    protected function handleGroupType()
    {
    }
}
