<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Addons\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Hook
{

    /**
     * @var array
     */
    public $name;
}
