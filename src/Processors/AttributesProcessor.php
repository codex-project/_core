<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Processors;

use Codex\Addons\Annotations\Processor;
use Codex\Documents\Document;
use Codex\Support\Collection;
use Symfony\Component\Yaml\Yaml;

/**
 * Frontmatter filter
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 *
 * @Processor("attributes", priority=0, config="config")
 *
 */
class AttributesProcessor
{
    /** @var Collection */
    public $config = 'codex.processors.attributes';

    /**
     * handle method
     *
     * @param \Codex\Documents\Document $document
     */
    public function handle(Document $document)
    {
        $this->process($document);
    }

    protected function addInformationalAttributes(Document $document)
    {
        $document->getFiles()->lastModified($document->getPath());
    }

    protected function getTagsPattern()
    {
        $open  = [ ];
        $close = [ ];
        foreach ($this->config[ 'tags' ] as $tag) {
            $open[]  = $tag[ 'open' ];
            $close[] = $tag[ 'close' ];
        }
        return '/^(?:' . implode('|', $open) . ')([\w\W]*?)(?:' . implode('|', $close) . ')/';
    }

    protected function process(Document $document)
    {
        $content = $document->getContent();
        $pattern = $this->getTagsPattern();
        if (preg_match($pattern, $content, $matches) === 1) {
            // not really required when using html doc tags. But in case it's frontmatter, it should be removed
            if ($this->config[ 'remove_tags' ] === true) {
                $content = preg_replace($pattern, '', $content);
            }
            $data = Yaml::parse($matches[ 1 ]);
            if (is_array($data)) {
                $attributes = array_replace_recursive($document->getAttributes(), $data);

                $document->setAttributes($attributes);
            }
        }
        if ($this->config[ 'remove_tags' ] === true) {
            $document->setContent($content);
        }

        return $this;
    }
}

#class AttributesFilter
