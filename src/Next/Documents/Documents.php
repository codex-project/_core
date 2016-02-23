<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Documents;


use Codex\Core\Next\Contracts;
use Codex\Core\Next\Contracts\Codex;
use Codex\Core\Next\Exception\DocumentNotFoundException;
use Codex\Core\Next\Projects\Project;
use Codex\Core\Next\Traits;

class Documents implements
    Contracts\Documents,
    Contracts\Extendable,
    Contracts\Hookable,
    Contracts\Bootable
{
    use Traits\ExtendableTrait,
        Traits\HookableTrait,
        Traits\ObservableTrait,
        Traits\BootableTrait,

        Traits\CodexTrait;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * @var \Codex\Core\Next\Projects\Project
     */
    protected $project;

    public function __construct(Project $parent, Codex $codex)
    {
        $this->items   = collect();
        $this->project = $parent;
        $this->setCodex($codex);
    }

    /**
     * all method
     *
     * @return \Codex\Core\Document[]
     */
    public function all()
    {
        return $this->items->all();
    }


    public function has($pathName = '')
    {
        if ( $pathName === '' ) {
            $pathName = 'index';
        }
        return $this->project->getFiles()->exists($this->project->refPath($pathName . '.md'));
    }

    /**
     * Get a document by path. Returns an instance of document
     *
     * @param string $pathName
     *
     * @return \Codex\Core\Document
     */
    public function get($pathName = '')
    {
        if ( $pathName === '' ) {
            $pathName = 'index';
        }

        if ( !$this->items->has($pathName) ) {
            $path = $pathName . '.md';


            $this->items->put($pathName, $this->getContainer()->make('codex.document', [
                'codex'    => $this->getCodex(),
                'project'  => $this->getProject(),
                'path'     => $path,
                'pathName' => $pathName,
            ]));

            $this->hookPoint('project:document', [ $this->items->get($pathName) ]);
        }

        if ( !$this->items->has($pathName) ) {
            throw DocumentNotFoundException::document($pathName);
        }

        return $this->items->get($pathName);
    }

    # Menu

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

}
