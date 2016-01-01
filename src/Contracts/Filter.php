<?php
namespace Codex\Core\Contracts;

use Codex\Core\Document;

/**
 * Filter contract
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 */
interface Filter
{
    public function handle(Document $document, array $config);
}
