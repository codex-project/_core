<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Documents;


use Closure;
use Codex\Core\Contracts;
use Codex\Core\Contracts\Codex;
use Codex\Core\Exception\CodexException;
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

        $this->hookPoint('documents:constructed');
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
     * @return Document
     * @throws \Codex\Core\Exception\DocumentNotFoundException
     */
    public function get($pathName = '')
    {
        return $this->resolve($pathName);
    }

    protected function resolvePathName($pathName = null)
    {
        $pathName = $pathName ?: 'index';
        $this->hookPoint('documents:resolve:path', [$pathName]);

        if(array_key_exists($pathName, $this->customDocuments)){
            return $this->getCodex()->getContainer()->call($this->customDocuments[$pathName], [ 'documents' => $this]);
        }
        foreach ( $this->getCodex()->config('extensions', []) as $extension => $binding ) {
            $path = $this->project->refPath("{$pathName}.{$extension}");
            if ( $this->project->getFiles()->exists($path) ) {
                return compact('path', 'extension', 'binding');
            }
        }

        return false;
    }

    public function resolve($pathName = null)
    {
        $this->hookPoint('documents:resolve', [$pathName]);
        $resolved = $this->resolvePathName($pathName);

        if ( $resolved['path'] === false ) {
            throw CodexException::documentNotFound($pathName);
        }

        if ( ! $this->items->has($pathName) ) {
            $document = $this->getCodex()->getContainer()->make($resolved['binding'], [
                'codex'     => $this->getCodex(),
                'project'   => $this->getProject(),
                'path'      => $resolved['path'],
                'pathName'  => $pathName
            ]);
            $this->items->put($pathName, $document);
            $this->hookPoint('project:document', [ $this->items->get($pathName) ]);
        }

        if ( ! $this->items->has($pathName) ) {
            throw DocumentNotFoundException::document($pathName);
        }

        return $this->items->get($pathName);
    }

    protected $customDocuments = [];

    public function addCustomDocument($pathName, Closure $resolver)
    {
        $this->customDocuments[$pathName] = $resolver;
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
