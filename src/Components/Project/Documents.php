<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Components\Project;

use Codex\Core\Project;
use Codex\Core\Traits\Hookable;
use Sebwite\Support\Path;
use Symfony\Component\Finder\Finder;

class Documents extends ProjectComponent
{
    use Hookable;

    protected $items;

    public function __construct(Project $parent)
    {
        parent::__construct($parent);
        $this->items = collect();
        $this->resolve();
    }

    public function resolve()
    {
        $files = Finder::create()->in($this->path())->files()->depth('<= 4')->contains('.md');
        foreach ($files as $file) {
        /** @var \SplFileInfo $file */
            $path = $file->getPathname();
            $a    = 'a';
        }
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

    public function has($name)
    {
        return $this->items->has($name);
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
            $path = Path::join($this->project->path(), $pathName . '.md');

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
