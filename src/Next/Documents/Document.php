<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Documents;


use Codex\Core\Exceptions\DocumentNotFoundException;
use Codex\Core\Next\Contracts;
use Codex\Core\Next\Contracts\Codex;
use Codex\Core\Next\Projects\Project;
use Codex\Core\Next\Traits;

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

    public function getName()
    {
        return $this->pathName;
    }


    public function __construct(Codex $codex, Project $project, $path, $pathName)
    {
        $this->setCodex($codex);
        $this->project  = $project;
        $this->path     = $project->refPath($path);
        $this->pathName = $pathName;

        $this->setFiles($project->getFiles());

        $this->hookPoint('document:ready', [ $this ]);

        $this->attributes = $codex->config('default_document_attributes');

        if ( !$this->getFiles()->exists($this->path) ) {
            throw DocumentNotFoundException::document($this)->inProject($project);
        }

        $this->content = $this->getFiles()->get($this->path);

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

        $fsettings = $this->project->config('filters');
        $filters   = Extender::getFilters($this->project->config('filters.enabled'));

        if ( count($filters) > 0 ) {
            foreach ( $filters as $name => $filter ) {
                if ( $filter instanceof \Closure ) {
                    call_user_func_array($filter, [ $this, isset($fsettings[ $name ]) ? $fsettings[ $name ] : [ ] ]);
                } else {
                    $instance = app()->make($filter);
                    call_user_func_array([ $instance, 'handle' ], [ $this, isset($fsettings[ $name ]) ? $fsettings[ $name ] : [ ] ]);
                }
            }
        }

        return $this->content;
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
     * Get the url to this document
     *
     * @return string
     */
    public function url()
    {
        return $this->codex->url($this->project, $this->project->getRef(), $this->pathName);
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
     * get the path value.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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

    /**
     * Get the document's project.
     *
     * @return \Codex\Core\Project
     */
    public function getProject()
    {
        return $this->project;
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
}
