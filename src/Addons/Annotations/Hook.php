<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Addons\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
final class Hook
{

    /**
     * @Required()
     * @var string
     */
    public $name;

    /**
     * @var string|bool
     */
    public $replace = false;

}
