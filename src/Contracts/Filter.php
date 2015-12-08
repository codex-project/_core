<?php
namespace Docit\Core\Contracts;

use Docit\Core\Document;

/**
 * Filter contract
 *
 * @package   Docit\Core
 * @author    Docit Project Dev Team
 * @copyright Copyright (c) 2015, Docit Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
interface Filter
{
    public function handle(Document $document, array $config);
}
