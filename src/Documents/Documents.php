<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Documents;


use Closure;
use Codex\Codex;
use Codex\Contracts;
use Codex\Exception\CodexException;
use Codex\Projects\Project;
use Codex\Projects\Ref;
use Codex\Support\Extendable;
use Codex\Support\Traits\FilesTrait;
use Illuminate\Contracts\Support\Arrayable;
use Laradic\Support\Str;

class Documents extends Extendable implements Contracts\Documents\Documents, Arrayable
{
    use FilesTrait;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * @var \Codex\Projects\Project
     */
    protected $project;

    protected $ref;

    protected $extension;

    public function __construct(Ref $parent, Codex $codex)
    {
        $this->items   = collect();
        $this->ref     = $parent;
        $this->project = $parent->getProject();
        $this->setCodex($codex);
        $this->setFiles($parent->getFiles());

        $this->hookPoint('documents:constructing');
        $this->resolveAll();
        $this->hookPoint('documents:constructed');
    }

    public function resolveAll()
    {
        $fs    = $this->getFiles();
        $files = $fs->files($this->ref->path(), true);
        foreach ( $files as $file ) {
            $file = Str::removeLeft($file, $this->ref->getName() . DIRECTORY_SEPARATOR);
            $file = Str::removeRight($file, '.' . path_get_extension($file));
            $this->resolvePathName($file) && $this->resolve($file);
        }
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

    public function in($dir)
    {
        return $this->items->filter(function ($doc, $path) use ($dir) {
            return Str::startsWith($path, $dir);
        });
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
            $path = $this->ref->path("{$pathName}.{$extension}");
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

        if ( $resolved === false ) {
            throw CodexException::documentNotFound($pathName);
        }

        if ( !$this->items->has($pathName) ) {
            $document = $this->getCodex()->getContainer()->make($resolved[ 'binding' ], [
                'codex'    => $this->getCodex(),
                'project'  => $this->getProject(),
                'ref' => $this->getRef(),
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
        return $this->resolvePathName($pathName) !== false;
    }

    /**
     * @return \Codex\Projects\Ref
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items->transform(function(Document $document){
            return [
                'name' => $document->getName(),
                'url' => $document->url(),
                'breadcrumb' => $document->getBreadcrumb(),
                'processed' => $document->getProcessed()->toArray()
            ];
        })->toArray();
    }
}
