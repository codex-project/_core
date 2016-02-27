<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Documents;


class HtmlDocument extends Document
{

}
codex()
    ->projects
    ->get('codex-core')
    ->documents
    ->get('index')
    ->render();

# Register for specific extensions
codex()->registerFilter('attributes', Filters\AttributesFilter::class, ['html', 'md']);

# Register globally
codex()->registerFilter('attributes', Filters\AttributesFilter::class);

# Register document type
codex()->registerDocument('html', HtmlDocument::class);
