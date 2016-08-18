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


use Codex\Codex;
use Codex\Exception\CodexException;
use Codex\Projects\Project;
use Codex\Projects\Ref;
use Codex\Support\Traits;
use Codex\Support\Collection;
use Codex\Support\Extendable;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Support\Arrayable;

/**
 * This is the class Document.
 *
 * @package        Codex\Documents
 * @author         Robin Radic
 */
class Document extends Extendable implements Arrayable
{
    use Traits\FilesTrait,
        Traits\AttributesTrait;

    const CACHE_AUTO = 'auto';
    const CACHE_ENABLED = 'enabled';
    const CACHE_DISABLED = 'disabled';

    /** @var string */
    protected $originalContent;

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
     * @var \Codex\Projects\Project
     */
    protected $project;

    /**
     * The pathname is the path given to Project->getDocument. It's a relative path
     *
     * @var string
     */
    protected $pathName;

    /** @var string */
    protected $extension;

    /** @var \Codex\Support\Collection */
    protected $processed;

    protected $rendered = false;

    /** @var ContentDom */
    protected $contentDom;

    /** @var \Illuminate\Contracts\Cache\Repository */
    protected $cache;

    /** @var int */
    protected $lastModified;

    /**
     * Caching mode.
     *
     * Document::CACHE_AUTO         depends on APP_DEBUG.
     * Document::CACHE_ENABLED      enables the cache
     * Document::CACHE_DISABLED     disables the cache
     *
     * @var string
     */
    protected $mode = self::CACHE_AUTO;

    /** @var \Codex\Projects\Ref  */
    protected $ref;

    /**
     * Document constructor.
     *
     * @param \Codex\Codex|\Codex\Contracts\Codex    $codex
     * @param \Codex\Projects\Project                $project
     * @param \Codex\Projects\Ref                    $ref
     * @param \Illuminate\Contracts\Cache\Repository $cache
     * @param                                        $path
     * @param                                        $pathName
     *
     * @throws \Codex\Exception\CodexException
     */
    public function __construct(Codex $codex, Project $project, Ref $ref, Repository $cache, $path, $pathName)
    {
        $this->setCodex($codex);
        $this->setFiles($project->getFiles());
        $this->ref = $ref;
        $this->project   = $project;
        $this->path      = $path;
        $this->pathName  = $pathName;
        $this->cache     = $cache;
        $this->extension = path_get_extension($path);
        $this->processed = new Collection();

        $this->hookPoint('document:construct', [ $this ]);

        #$this->codex->projects->hasActive() === false && $project->setActive();

        if ( !$this->getFiles()->exists($this->getPath()) ) {
            throw CodexException::documentNotFound("{$this} in [{$project}]");
        }

        $this->attributes   = $codex->config('default_document_attributes');
        $this->lastModified = $this->getFiles()->lastModified($this->getPath());
        $this->setCacheMode($this->getCodex()->config('document.cache.mode', self::CACHE_DISABLED));

        //$this->content = $this->getFiles()->get($this->getPath());
        $this->attr('view', null) === null && $this->setAttribute('view', $codex->view('document'));


        $this->hookPoint('document:constructed', [ $this ]);
    }

    /**
     * Get the url to this document
     *
     * @return string
     */
    public function url()
    {
        return $this->codex->url($this->project, $this->ref, $this->pathName);
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
        if ( $this->rendered ) {
            return $this->content;
        }
        // todo implement this. if changes are made that influence the attributes (ex, the project config), the cache should drop.
        // this is a example of how to create a unique hash for it. not sure if it would work out
//        $attributesChanged = md5(collect(array_dot($this->attributes))->values()->transform(function ($val) {
//            return md5((string)$val);
//        })->implode('.'));


        $this->codex->dev->benchmark('document');
        $this->hookPoint('document:render');
        if ( $this->shouldCache() ) {
            $minutes = $this->getCodex()->config('document.cache.minutes', null);
            if ( $minutes === null ) {
                $lastModified = (int)$this->cache->rememberForever($this->getCacheKey(':last_modified'), function () {
                    return 0;
                });
            } else {
                $lastModified = (int)$this->cache->remember($this->getCacheKey(':last_modified'), $minutes, function () {
                    return 0;
                });
            }
            if ( $this->lastModified !== $lastModified || $this->cache->has($this->getCacheKey()) === false ) {
                $this->runProcessors();
                $this->cache->put($this->getCacheKey(':last_modified'), $this->lastModified, $minutes);
                $this->cache->put($this->getCacheKey(':content'), $this->content, $minutes);
            } else {
                $this->content = $this->cache->get($this->getCacheKey(':content'));
            }
        } else {
            $this->runProcessors();
        }
        $this->rendered = true;
        $this->hookPoint('document:rendered');
        $this->codex->dev->addMessage($this->toArray());
        $this->codex->dev->stopBenchmark(true);
        return $this->content;
    }

    public function getCacheKey($suffix = '')
    {
        return 'codex.document.' . $this->project->getName() . '.' . str_slug($this->pathName) . $suffix;
    }

    /**
     * Run all the content processors that haven't run.
     *
     * @throws \Codex\Exception\CodexException
     */
    public function runProcessors()
    {
        $this->runProcessor('attributes');
        $processors = $this->getEnabledProcessors();
        foreach ( $this->getProcessors()->getSorted($processors) as $processor ) {
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
    protected function runProcessor($name)
    {
        if ( $this->processed->has($name) ) {
            return;
        }
        $this->processed->set($name, $this->getProcessors()->run($name, $this));
    }

    #
    # COMPUTATED GETTERS & SETTERS
    #

    /**
     * toArray method
     * @return array
     */
    public function toArray()
    {
        return [
            'path'              => $this->path,
            'pathName'          => $this->pathName,
            'extension'         => $this->extension,
            'cacheMode'         => $this->mode,
            'lastModified'      => $this->lastModified,
            'attributes'        => $this->attr(),
            'enabledProcessors' => $this->getEnabledProcessors()
        ];
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
        return []; //$this->ref->getSidebarMenu()->getBreadcrumbToHref($this->url());
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
        if ( $content instanceof ContentDom ) {
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
        if ( null === $this->contentDom ) {
            $this->contentDom = new ContentDom($this);
        }
        return $this->contentDom->set($this->getContent());
    }

    /**
     * getDom method
     * @return \FluentDOM\Query
     */
    public function getDom()
    {
        return \FluentDOM::Query($this->getContent(), 'text/html');
    }

    /** @param \FluentDOM\Query $dom */
    public function setDom($dom)
    {
        $this->content = $dom->find('//body')->first()->html();
    }

    public function shouldCache()
    {
        return $this->mode === self::CACHE_ENABLED || ($this->mode === self::CACHE_AUTO && config('app.debug', false) === true);
    }

    public function setCacheMode($mode)
    {
        if ( $mode === true ) {
            $mode = self::CACHE_ENABLED;
        } elseif ( $mode === false ) {
            $mode = self::CACHE_DISABLED;
        } elseif ( $mode === null ) {
            $mode = self::CACHE_AUTO;
        }
        if ( !in_array($mode, [ self::CACHE_ENABLED, self::CACHE_DISABLED, self::CACHE_AUTO ], true) ) {
            throw CodexException::because('Cache mode not supported: ' . (string)$mode);
        }
        $this->mode = $mode;
    }


    #
    # GETTERS & SETTERS
    #

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
        if ( false === isset($this->content) ) {
            $this->content = $this->getFiles()->get($this->getPath());
        }
        return $this->content;
    }

    public function getOriginalContent()
    {
        if ( false === isset($this->originalContent) ) {
            $this->originalContent = $this->getFiles()->get($this->getPath());
        }
        return $this->originalContent;
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

    /**
     * @return Ref
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
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

    /**
     * getProcessors method
     * @return \Codex\Addons\Collections\Processors
     */
    protected function getProcessors()
    {
        return $this->codex->addons->processors;
    }

    /**
     * @return Repository
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Set the cache value
     *
     * @param Repository $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return string
     */
    public function getPathName()
    {
        return $this->pathName;
    }

    /**
     * @return int
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    public function __toString()
    {
        return $this->pathName;
    }

}
