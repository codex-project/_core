<?php
namespace Codex\Core\Filters;

use Codex\Core\Contracts\Filter;
use Codex\Core\Document;
use Symfony\Component\Yaml\Yaml;

/**
 * Frontmatter filter
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
class FrontMatterFilter implements Filter
{
    /**
     * Handle the filter.
     *
     * @param \Codex\Core\Document $document
     * @param array                $config
     *
*@return void
     */
    public function handle(Document $document, array $config)
    {
        $this->pattern($document, '/<!---([\w\W]*?)-->/')
            ->pattern($document, '/---([\w\W]*?)---/');
    }

    protected function pattern(Document $document, $pattern)
    {
        $content = $document->getContent();

        if (preg_match($pattern, $content, $matches) === 1) {
            // not really required when using html doc tags. But in case it's frontmatter, it should be removed
            $content    = preg_replace($pattern, '', $content);
            $attributes = array_replace_recursive($document->getAttributes(), Yaml::parse($matches[1]));

            $document->setAttributes($attributes);
        }

        $document->setContent($content);

        return $this;
    }
}
