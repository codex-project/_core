<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright $today.year (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Documents;


use Codex\Contracts;
use Codex\Contracts\Codex;
use Codex\Exception\DocumentNotFoundException;
use Codex\Projects\Project;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Codex\Traits;

/**
 * This is the class Document.
 *
 * @package        Codex\Documents
 * @author         Robin Radic
 */
class Document extends Extendable
{
    use Traits\FilesTrait,
        Traits\AttributesTrait;


    /**
     * @var string
     */
    protected $content;

    /**
     * Absolute path to this document
     *
     * @var string
     */
    protected $path;

    /**
     * The project instance
     *
     * @var \Codex\Project
     */
    protected $project;

    /**
     * The pathname is the path given to Project->getDocument. It's a relative path
     *
     * @var string
     */
    protected $pathName;

    protected $extension;

    /** @var \Codex\Support\Collection */
    protected $processed;

    protected $rendered = false;

    /** @var ContentDom */
    protected $contentDom;


    /**
     * Document constructor.
     *
     * @param \Codex\Contracts\Codex|\Codex\Codex           $codex
     * @param \Codex\Projects\Project                       $project
     * @param                                               $type
     * @param                                               $path
     * @param                                               $pathName
     *
     * @throws \Codex\Exception\DocumentNotFoundException
     */
    public function __construct(Codex $codex, Project $project, $path, $pathName)
    {
        $this->setCodex($codex);
        $this->project   = $project;
        $this->path      = $path;
        $this->pathName  = $pathName;
        $this->extension = path_get_extension($path);
        $this->processed = new Collection();

        $this->setFiles($project->getFiles());

        $this->hookPoint('document:ready', [ $this ]);

        if ( $this->codex->projects->hasActive() === false )
        {
            $project->setActive();
        }

        $this->attributes = $codex->config('default_document_attributes');

        if ( ! $this->getFiles()->exists($this->getPath()) )
        {
            throw DocumentNotFoundException::document($this)->inProject($project);
        }

        $this->content = $this->getFiles()->get($this->getPath());

        $this->attr('view', null) === null && $this->setAttribute('view', $codex->view('document'));

        # $this->bootIfNotBooted();

        $this->hookPoint('document:done', [ $this ]);
    }

    /**
     * Render the document.
     *
     * This will run all document:render hooks and then return the
     * output. Should be called within a view.
     *
     * @return string
     */
    public function render()
    {
        if ( $this->rendered )
        {
            return $this->content;
        }
        $this->hookPoint('document:render');
        $this->runProcessors();
        $this->rendered = true;
        $this->hookPoint('document:rendered');
        return $this->content;
    }

    /**
     * Run all the content processors that haven't run.
     *
     * @throws \Codex\Exception\CodexException
     */
    public function runProcessors()
    {
        $processors = $this->getEnabledProcessors();
        foreach ( $this->getProcessors()->getSorted($processors) as $processor )
        {
            $this->runProcessor($processor);
        }
    }

    /**
     * Run a content processor
     *
     * @param $name
     *
     * @throws \Codex\Exception\CodexException
     */
    public function runProcessor($name)
    {
        if ( $this->processed->has($name) )
        {
            return;
        }
        $this->processed->set($name, $this->getProcessors()->run($name, $this));
    }

    /**
     * Get the names of all enabled processors for this document
     *
     * @return array
     */
    public function getEnabledProcessors()
    {
        $enabled  = $this->project->config('processors.enabled', [ ]);
        $enabled2 = $this->attr('processors.enabled', [ ]);
        $disabled = $this->attr('processors.disabled', [ ]);
        return array_diff(array_unique(array_merge($enabled, $enabled2)), $disabled);
    }

    /**
     * Returns an array of parent menu items
     *
     * @return array
     */
    public function getBreadcrumb()
    {
        return $this->project->getSidebarMenu()->getBreadcrumbToHref($this->url());
    }

    /**
     * Get the url to this document
     *
     * @return string
     */
    public function url()
    {
        return $this->codex->url($this->project, $this->project->getRef(), $this->pathName);
    }


    /**
     * get the path value.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path value.
     *
     * @param  string $path
     *
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * getName method
     *
     * @return string
     */
    public function getName()
    {
        return $this->pathName;
    }

    /**
     * get the content of the document.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the content value of the document.
     *
     * @param  ContentDom|string $content
     *
     * @return Document
     */
    public function setContent($content)
    {
        if ( $content instanceof ContentDom )
        {
            $content = (string)$content->root->outerhtml();
        }
        $this->content = $content;

        return $this;
    }

    /**
     * getContentDom method
     * @return \Codex\Documents\ContentDom
     */
    public function getContentDom()
    {
        if ( null === $this->contentDom )
        {
            $this->contentDom = new ContentDom($this);
        }
        return $this->contentDom->set($this->content);
    }

    /**
     * Get the document's project.
     *
     * @return \Codex\Projects\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return boolean
     */
    public function isRendered()
    {
        return $this->rendered;
    }

    /**
     * getAppliedFilters method
     *
     * @return \Codex\Support\Collection
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    public function toArray()
    {
        return [
            'path'           => $this->path,
            'pathName'       => $this->pathName,
            'extension'      => $this->extension,
            'appliedFilters' => $this->processed->pluck('name')->toArray(),
        ];
    }

    /**
     * getProcessors method
     * @return \Codex\Addons\ProcessorAddons
     */
    protected function getProcessors()
    {
        return $this->codex->addons->processors;
    }
}
