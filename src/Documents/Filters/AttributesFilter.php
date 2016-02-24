<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


use Codex\Core\Documents\Document;
use Codex\Core\Documents\Filter;
use Sebwite\Support\Collection;
use Symfony\Component\Yaml\Yaml;

/**
 * Frontmatter filter
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class AttributesFilter implements Filter
{
    /**
     * Handle the filter.
     *
     * @param \Codex\Core\Document $document
     * @param array                $config
     *
     * @return void
     */
    public function handle(Document $document, $settings)
    {
        $this->pattern($document, '/<!--([\w\W]*?)-->/')
            ->pattern($document, '/--([\w\W]*?)--/');
    }

    protected function pattern(Document $document, $pattern)
    {
        $content = $document->getContent();

        if ( preg_match($pattern, $content, $matches) === 1 ) {
            // not really required when using html doc tags. But in case it's frontmatter, it should be removed
            $content = preg_replace($pattern, '', $content);
            $data    = Yaml::parse($matches[ 1 ]);
            if ( is_array($data) ) {
                $attributes = array_replace_recursive($document->getAttributes(), $data);

                $document->setAttributes($attributes);
            }
        }

        $document->setContent($content);

        return $this;
    }
}

#class AttributesFilter
