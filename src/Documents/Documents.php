<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Documents;


use Codex\Core\Contracts;
use Codex\Core\Contracts\Codex;
use Codex\Core\Exception\DocumentNotFoundException;
use Codex\Core\Projects\Project;
use Codex\Core\Traits;

class Documents implements
    Contracts\Documents,
    Contracts\Hookable
{
    use Traits\HookableTrait,
        Traits\CodexTrait;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * @var \Codex\Core\Projects\Project
     */
    protected $project;

    protected $extension;

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

    /**
     * get method
     *
     * @param string $pathName
     *
     * @return \Codex\Core\Documents\Document
     * @throws \Codex\Core\Exception\DocumentNotFoundException
     */
    public function get($pathName = '')
    {
        $ext = $this->resolvePathName($pathName);

        if ( $ext === false ) {
            throw DocumentNotFoundException::document($pathName);
        }

        $extension = $ext->get('extension', 'html');
        $path      = $ext->get('path');
        $handler   = $ext->get('handler', 'codex.document');


        if ( !$this->items->has($pathName) ) {
            $this->items->put($pathName, $this->getCodex()->getContainer()->make($handler, [
                'codex'     => $this->getCodex(),
                'project'   => $this->getProject(),
                'path'      => $path,
                'pathName'  => $pathName,
                'extension' => $extension,
            ]));

            $this->hookPoint('project:document', [ $this->items->get($pathName) ]);
        }

        if ( !$this->items->has($pathName) ) {
            throw DocumentNotFoundException::document($pathName);
        }

        return $this->items->get($pathName);
    }

    public function resolvePathName($pathName = null)
    {
        $pathName = $pathName ?: 'index';

        $extensions = $this->getCodex()->getDocuments();
        foreach ( $extensions->keys()->toArray() as $extension ) {
            $path = $this->project->refPath("{$pathName}.{$extension}");
            if ( $this->project->getFiles()->exists($path) ) {
                $handler = $extensions->get($extension);
                return collect(compact('extension', 'path', 'handler'));
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    # Menu

    public function has($pathName = null)
    {
        return $this->resolvePathName($pathName) !== false;
    }

}
