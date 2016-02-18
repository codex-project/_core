<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Documents;


use Codex\Core\Next\Projects\Project;

class Documents
{


    protected $items;

    public function __construct(Project $parent)
    {
        $this->items = collect();
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
        if ($pathName === '') {
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
        if ($pathName === '') {
            $pathName = 'index';
        }

        if (!$this->items->has($pathName)) {
            $path = $pathName . '.md';


            $this->items->put($pathName, $this->getContainer()->make('codex.document', [
                'codex'    => $this->getCodex(),
                'project'  => $this->getProject(),
                'path'     => $path,
                'pathName' => $pathName
            ]));

            $this->runHook('project:document', [ $this->items->get($pathName) ]);
        }


        return $this->items->get($pathName);
    }
    # Menu
}
