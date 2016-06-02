<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Documents;


use Codex\Contracts;
use Codex\Contracts\Codex;
use Codex\Exception\DocumentNotFoundException;
use Codex\Projects\Project;
use Codex\Support\Collection;
use Codex\Traits;

class Document implements
    Contracts\Extendable,
    Contracts\Hookable,
    Contracts\Bootable
{
    use Traits\ExtendableTrait,
        Traits\HookableTrait,
        Traits\ObservableTrait,
        Traits\BootableTrait,

        Traits\CodexTrait,
        Traits\FilesTrait;

    /**
     * The document attributes. Defaults can be set in the config, documents can use frontmatter to customize it.
     *
     * @var array
     */
    protected $attributes;

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


    /** @var \Codex\Support\Collection  */
    protected $appliedFilters;


    protected $rendered = false;

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
        $this->project        = $project;
        $this->path           = $path;
        $this->pathName       = $pathName;
        $this->extension      = path_get_extension($path);
        $this->appliedFilters = new Collection();

        $this->setFiles($project->getFiles());

        $this->hookPoint('document:ready', [ $this ]);

        if ( $this->codex->projects->hasActive() === false ) {
            $project->setActive();
        }

        $this->attributes = $codex->config('default_document_attributes');

        if ( !$this->getFiles()->exists($this->getPath()) ) {
            throw DocumentNotFoundException::document($this)->inProject($project);
        }

        $this->content = $this->getFiles()->get($this->getPath());

        $this->attr('view', null) === null && $this->setAttribute('view', $codex->view('document'));

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
        if($this->rendered){
            return $this->content;
        }
        $this->hookPoint('document:render');
        $this->runFilters();
        $this->rendered = true;
        $this->hookPoint('document:rendered');
        return $this->content;
    }

    protected function runFilters()
    {
        $enabledFilters = $this->project->config('filters.enabled', []);

        foreach (  $this->codex->addons->filters->getSorted($enabledFilters) as $filter ) {

            $this->hookPoint('document:filter:before:' . $filter['name'], [ $filter['instance'],  $filter ]);
            $this->codex->addons->filters->runFilter($filter['name'], $this);
            //app()->call([ $filter['instance'], 'handle' ], ['document' => $this]);
            $this->appliedFilters->add($filter);
            $this->hookPoint('document:filter:after:' . $filter['name'], [ $filter['instance'], $filter ]);
        }
    }

    /**
     * Get a attribute using dot notation
     *
     * @param  string    $key
     * @param null|mixed $default
     *
     * @return array|null|mixed
     */
    public function attr($key = null, $default = null)
    {
        return is_null($key) ? $this->attributes : array_get($this->attributes, $key, $default);
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
     * @param  string $content
     *
     * @return Document
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get all document attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the document attributes.
     *
     * @param  array $attributes
     *
     * @return Document
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * mergeAttributes
     *
     * @param array $attributes
     *
     * @return $this
     */
    public function mergeAttributes(array $attributes)
    {
        $this->attributes = array_replace_recursive($this->attributes, $attributes);

        return $this;
    }

    public function setAttribute($key, $value)
    {
        data_set($this->attributes, $key, $value);
        return $this;
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
     * @return \Codex\Support\Collection
     */
    public function getAppliedFilters()
    {
        return $this->appliedFilters;
    }

}
