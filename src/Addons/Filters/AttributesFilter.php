<?php
namespace Codex\Core\Addons\Filters;

use Codex\Core\Addons\Annotations\Config;
use Codex\Core\Addons\Annotations\Filter;
use Codex\Core\Addons\Types\FilterType;
use Codex\Core\Documents\Document;
use Symfony\Component\Yaml\Yaml;

/**
 * Frontmatter filter
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 *
 * @Filter("attributes", for={"html", "markdown"})
 *
 */
class AttributesFilter
{
    /** @var FilterType */
    public $type;

    /**
     * @Config(type = "filter", name = "attributes")
     * @var array
     */
    public $config = [
        'tags' => [
            ['open' => '<!--*', 'close' => '--*>'], // html
            ['open' => '---', 'close' => '---'], // markdown (frontmatter)
        ]
    ];

    /**
     * handle method
     *
     * @param \Codex\Core\Documents\Document $document
     */
    public function handle(Document $document)
    {
        /* https://regex101.com/r/kD5jK5/1 */
        $this->pattern($document, '/^(?:<!--*|---)([\w\W]*?)(?:--*>|---)/');
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
