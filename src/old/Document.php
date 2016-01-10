<?php
/**
* Part of the Codex PHP packages.
*
* MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core;

use Codex\Core\Contracts\Codex;
use Codex\Core\Traits;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Document class.
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class Document2
{
    use Traits\Hookable, Traits\FilesTrait, Traits\CodexTrait, Traits\ContainerTrait;

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

    /**
     * Creates a new Document class
     *
     * @param \Codex\Core\Contracts\Codex                 $codex     The factory class
     * @param \Illuminate\Contracts\Filesystem\Filesystem $files     The filesystem
     * @param \Codex\Core\Project                         $project   The project instance
     * @param \Illuminate\Contracts\Container\Container   $container The container class
     * @param string                                      $path      The absolute path to the document
     * @param string                                      $pathName  The relative path to the document
     */
    public function __construct(Codex $codex, Filesystem $files, Project $project, Container $container, $path, $pathName)
    {
        $this->setContainer($container);
        $this->setCodex($codex);
        $this->setFiles($files);

        $this->project   = $project;
        $this->path      = $path;
        $this->pathName  = $pathName;

        $this->runHook('document:ready', [ $this ]);

        $this->attributes = $codex->config('default_document_attributes');
        $this->content    = $this->files->get($this->path);

        $this->runHook('document:done', [ $this ]);
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
        $this->runHook('document:render', [ $this ]);

        $fsettings = $this->project->config('filters');
        $filters   = Extensions::getFilters($this->project->config('filters.enabled'));

        if (count($filters) > 0) {
            foreach ($filters as $name => $filter) {
                if ($filter instanceof \Closure) {
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
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}
