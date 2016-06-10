<?php

namespace Codex\Dev\Debugbar;

use Codex\Codex;
use Codex\Documents\Document;
use Codex\Http\Controllers\CodexController;
use Codex\Projects\Project;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * This is the class CodexCollector.
 *
 * @package        Codex\Dev
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
class CodexCollector extends DataCollector implements Renderable
{
    /** @var \Codex\Http\Controllers\CodexController */
    protected $controller;

    /** @var \Codex\Projects\Project */
    protected $project;

    /** @var \Codex\Documents\Document */
    protected $document;

    protected $documentFilters;

    /**
     * CodexCollector constructor.
     *
     * @param \Codex\Core\Http\Controllers\CodexController $controller
     * @param \Codex\Core\Projects\Project                 $project
     * @param \Codex\Core\Documents\Document               $document
     */
    public function __construct(CodexController $controller, View $view, Codex $codex, Project $project, Document $document)
    {
        // $controller, $view, $codex, $project, $document
        $this->controller = $controller;
        $this->project    = $project;
        $this->document   = $document;
    }

    public function getName()
    {
        return 'codex';
    }

    public function format($var)
    {
        return $this->getDataFormatter()->formatVar($var);
    }

    protected function transformAnnotationAddon(Collection $collection)
    {
        return $collection->transform(function ($item, $class) {
            return "{$item['name']}({$class}::class)";
        })->implode("\n");
    }

    /**
     * @{inheritDoc}
     */
    public function collect()
    {
        $c    = app('codex');
        $a    = $c->addons;
        $p    = $this->project;
        $d    = $this->document;
        $data = [
            'Display Name'        => $c->config('display_name'),
            'Base Route'          => $c->config('base_route')
        ];

        return $data;
    }

    /**
     * @{inheritDoc}
     */
    public function getWidgets()
    {
        $applied = $this->document->getAppliedFilters();
        return [
            'codex'                 => [
                'icon'    => 'lock',
                'widget'  => 'PhpDebugBar.Widgets.CodexWidget',
                'map'     => 'codex',
                'default' => '{}',
            ],
            'codex-document'        => [
                'icon'    => 'file-text',
                'tooltip' => 'Document Name',
                'map'     => 'codex.Document Name',
                'default' => '',
            ],
            'codex-project-version' => [
                'icon'    => 'code-fork',
                'tooltip' => 'Codex Project Version',
                'map'     => 'codex.Project Version',
                'default' => '',
            ],
            'codex-project'         => [
                'icon'    => 'book',
                'tooltip' => $this->format('Codex Project \n Filters: ' . $applied->implode(', ')),
                'map'     => 'codex.Project Name',
                'default' => '',
            ],
        ];
    }

}
