<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */

/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/11/16
 * Time: 6:21 AM
 */

namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Codex;
use Codex\Documents\Document;
use Codex\Processors\Buttons\Button;
use Codex\Support\Collection;

/**
 * Class ButtonsFilter
 *
 * @Processor("buttons", config="config", after={"parser", "toc", "header"})
 * @package Codex\Addons\Filters
 */
class ButtonsProcessor
{
    /** @var \Codex\Support\Collection */
    public $config = [
        'type'                => 'groups',
        'groups'              => [
//            'group-id' => [
//                'button-id' => [
//                    'text'   => 'Haai',
//                    'href'   => 'http://goto.com/this',
//                    'target' => '_blank',
//                ],
//            ]
        ],
        'buttons'             => [
//            'button-id' => [
//                'text'   => 'Haai',
//                'icon' => 'fa fa-github',
//                'attr' => [
//                    'href'   => 'http://goto.com/this',
//                    'target' => '_blank',
//                ]
//            ],
        ],
        'wrapper_class'       => 'top-buttons',
        'group_wrapper_class' => 'top-button-group',
    ];

    /** @var Document */
    public $document;

    /** @var Collection */
    protected $buttons;

    /** @var Codex */
    public $codex;

    protected function button($id, array $data = [ ], $gid = null)
    {
        $this->buttons->add(new Button($id, $data, $gid));
    }

    public function handle(Document $document)
    {
        $this->buttons = new Collection;

        // Merge project and document level config
        $this->config->customMerge($document->attr('buttons', []));

        $html = call_user_func([ $this, 'handle' . ucfirst($this->config[ 'type' ]) . 'Type' ]);
        $document->setContent($html . $document->getContent());
    }

    protected function handleGroupsType()
    {
        foreach ( $this->config[ 'groups' ] as $gid => $buttons )
        {
            foreach ( $buttons as $bid => $button )
            {
                $this->button($bid, $button, $gid);
            }
        }

        $groupIds = $this->buttons->pluck('groupId')->unique();
        $groups   = [ ];
        foreach ( $groupIds as $gid )
        {
            $groups[ $gid ] = $this->buttons->where('groupId', $gid)->all();
        }
        return $this->render(compact('groups'));
    }

    protected function handleButtonsType()
    {
        foreach ( $this->config[ 'buttons' ] as $bid => $button )
        {
            $this->button($bid, $button);
        }

        return $this->render([ 'buttons' => $this->buttons->all() ]);
    }

    protected function render($with = [ ])
    {
        $view = view(
            $this->codex->view('processors.buttons'),
            $this->config->except('buttons', 'groups')->all()
        )->with($with);

        return $view->render();
    }
}
