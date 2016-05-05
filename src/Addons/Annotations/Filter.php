<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addons\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Filter
{
    /**
     * @Required
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $priority = 10;

    /**
     * A public property name
     * @var bool|string
     */
    public $config = false;

    /**
     * @var string|bool
     */
    public $replace = false;

}
