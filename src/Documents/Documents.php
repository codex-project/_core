<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Documents;


use Closure;
use Codex\Contracts;
use Codex\Codex;
use Codex\Exception\CodexException;
use Codex\Projects\Project;
use Codex\Support\Extendable;
use Codex\Traits;

class Documents extends Extendable implements Contracts\Documents\Documents
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * @var \Codex\Projects\Project
     */
    protected $project;

    protected $extension;

    public function __construct(Project $parent, Codex $codex)
    {
        $this->items   = collect();
        $this->project = $parent;
        $this->setCodex($codex);

        $this->hookPoint('documents:constructed');
    }

    /**
     * all method
     *
     * @return \Codex\Document[]
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
     * @return Document
     */
    public function get($pathName = '')
    {
        return $this->resolve($pathName);
    }

    protected function resolvePathName($pathName = null)
    {
        $pathName = $pathName ?: 'index';
        $this->hookPoint('documents:resolve:path', [ $pathName ]);

        if ( array_key_exists($pathName, $this->customDocuments) ) {
            return $this->getCodex()->getContainer()->call($this->customDocuments[ $pathName ], [ 'documents' => $this ]);
        }
        foreach ( $this->getCodex()->config('document.extensions', [ ]) as $extension => $binding ) {
            $path = $this->project->refPath("{$pathName}.{$extension}");
            if ( $this->project->getFiles()->exists($path) ) {
                return compact('path', 'extension', 'binding');
            }
        }

        return false;
    }

    public function resolve($pathName = null)
    {
        $this->hookPoint('documents:resolve', [ $pathName ]);
        $resolved = $this->resolvePathName($pathName);

        if ( $resolved[ 'path' ] === false ) {
            throw CodexException::documentNotFound($pathName);
        }

        if ( !$this->items->has($pathName) ) {
            $document = $this->getCodex()->getContainer()->make($resolved[ 'binding' ], [
                'codex'    => $this->getCodex(),
                'project'  => $this->getProject(),
                'path'     => $resolved[ 'path' ],
                'pathName' => $pathName,
            ]);
            $this->items->put($pathName, $document);
            $this->hookPoint('project:document', [ $this->items->get($pathName) ]);
        }

        if ( !$this->items->has($pathName) ) {
            throw CodexException::documentNotFound($pathName);
        }

        return $this->items->get($pathName);
    }

    protected $customDocuments = [ ];

    public function addCustomDocument($pathName, Closure $resolver)
    {
        $this->customDocuments[ $pathName ] = $resolver;
    }

    /**
     * @return Project
     */
    public function getProject()
    {

        return $this->project;
    }

    # Menu

    public function has($pathName = null)
    {
        return $this->resolve($pathName) !== false;
    }
}
