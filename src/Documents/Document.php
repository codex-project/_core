<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Documents;


use Codex\Core\Contracts;
use Codex\Core\Contracts\Codex;
use Codex\Core\Exception\DocumentNotFoundException;
use Codex\Core\Projects\Project;
use Codex\Core\Traits;

abstract class Document implements
    Contracts\Extendable,
    Contracts\Hookable,
    Contracts\Bootable
{
    use Traits\ExtendableTrait,
        Traits\HookableTrait,
        Traits\ObservableTrait,
        Traits\BootableTrait,

        Traits\CodexTrait,
        Traits\FilesTrait,
        Traits\ConfigTrait;

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
     * @var \Codex\Core\Project
     */
    protected $project;

    /**
     * The pathname is the path given to Project->getDocument. It's a relative path
     *
     * @var string
     */
    protected $pathName;

    protected $type;

    protected $appliedFilters;

    /**
     * @return \Sebwite\Support\Collection|\Sebwite\Support\Collection
     */
    public function getAppliedFilters()
    {
        return $this->appliedFilters;
    }


    /**
     * Document constructor.
     *
     * @param \Codex\Core\Contracts\Codex|\Codex\Core\Codex $codex
     * @param \Codex\Core\Projects\Project                  $project
     * @param                                               $type
     * @param                                               $path
     * @param                                               $pathName
     *
     * @throws \Codex\Core\Exception\DocumentNotFoundException
     */
    public function __construct(Codex $codex, Project $project, $type, $path, $pathName)
    {
        $this->setCodex($codex);
        $this->project        = $project;
        $this->type           = $type;
        $this->path           = $path;
        $this->pathName       = $pathName;
        $this->appliedFilters = collect();

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
        $this->hookPoint('document:render', [ $this ]);
        $this->runFilters();
        $this->hookPoint('document:rendered', [ $this ]);
        return $this->content;
    }

    protected function runFilters($only = null)
    {
        #$projectConfig = $this->project->getConfig();

        foreach ( $this->project->getConfig()->getEnabledFilters($this) as $filter ) {
            $this->hookPoint('document:filter:before:' . $filter->getName(), [ $this, $filter ]);
            $filter->run($this);
            $this->hookPoint('document:filter:after:' . $filter->getName(), [ $this, $filter ]);
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
     * @return \Codex\Core\Projects\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    public function getType()
    {
        return $this->type;
    }
}
