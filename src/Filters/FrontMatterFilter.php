<?php
namespace Docit\Core\Filters;

use Docit\Core\Document;
use Docit\Core\Contracts\Filter;
use Symfony\Component\Yaml\Yaml;

/**
 * Frontmatter filter
 *
 * @package   Docit\Core
 * @author    Docit Project Dev Team
 * @copyright Copyright (c) 2015, Docit Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class FrontMatterFilter implements Filter
{
    /**
     * Handle the filter.
     *
     * @param \Docit\Core\Document $document
     * @param array $config
     * @return void
     */
    public function handle(Document $document, array $config)
    {
        $content = $document->getContent();

        $pattern = '/<!---([\w\W]*?)-->/';
        if (preg_match($pattern, $content, $matches) === 1) {
        // not really required when using html doc tags. But in case it's frontmatter, it should be removed
            $content    = preg_replace($pattern, '', $content);
            $attributes = array_replace_recursive($document->getAttributes(), Yaml::parse($matches[1]));

            $document->setAttributes($attributes);
        }

        $document->setContent($content);
    }
}
