<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Dev\Debugbar;

use Codex\Documents\Document;
use Codex\Support\Collection;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

/**
 * Collector for Laravel's Auth provider
 */
class CodexSimpleCollector extends DataCollector implements Renderable
{
    /** @var bool */
    protected $showVersion = true;

    protected $showProject = false;

    protected $showRef = true;

    protected $showDocument = true;

    /** @var Document|string */
    protected $document;

    protected $data;

    protected $codex;


    /**
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct()
    {
        $this->data = new Collection([

        ]);
    }

    public function data()
    {
        return $this->data;
    }

    /**
     * Set to show the users name/email
     *
     * @param bool $showVersion
     */
    public function setShowVersion($showVersion)
    {
        $this->showVersion = (bool)$showVersion;
    }

    public function setDocument(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @{inheritDoc}
     */
    public function collect()
    {
        $this->codex = $codex = codex();

        return [
            'version'  => '2.0.0-beta2', //$codex->getVersion(),
            'project'  => $this->document ? $this->document->getProject()->getName() : '',
            'ref'      => $this->document ? $this->document->getRef()->getName() : '',
            'document' => $this->document ? $this->document->getPath() : '',
            'data'     => $this->data->transform(function ($item) {
                if (! is_string($item)) {
                    $item = $this->getDataFormatter()->formatVar($item);
                }
                return $item;
            })->toArray(),
        ];
    }

    /**
     * @{inheritDoc}
     */
    public function getName()
    {
        return 'codex';
    }

    /**
     * @{inheritDoc}
     */
    public function getWidgets()
    {

        $widgets = [
            'codex' => [
                'icon'    => 'book',
                'widget'  => 'PhpDebugBar.Widgets.VariableListWidget',
                'map'     => 'codex.data',
                'default' => '{}',
            ],
        ];

        if ($this->showDocument && $this->document) {
            $widgets[ 'codex.document' ] = [
                'icon'    => 'file-text',
                'tooltip' => 'Document',
                'map'     => 'codex.document',
                'default' => '',
            ];
        }

        if ($this->showRef) {
            $widgets[ 'codex.ref' ] = [
                'icon'    => 'code-fork',
                'tooltip' => 'Project Version (ref)',
                'map'     => 'codex.ref',
                'default' => '',
            ];
        }

        if ($this->showProject) {
            $widgets[ 'codex.project' ] = [
                'icon'    => 'archive',
                'tooltip' => 'Project',
                'map'     => 'codex.project',
                'default' => '',
            ];
        }

        if ($this->showVersion) {
            $widgets[ 'codex.version' ] = [
                'icon'    => 'book',
                'tooltip' => 'Version',
                'map'     => 'codex.version',
                'default' => '',
            ];
        }
        return $widgets;
    }
}
