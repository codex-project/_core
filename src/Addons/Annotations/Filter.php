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
     * (optional) The property name of the default configuration this filter has. During runtime, this will be replaced with the actual, processed config Collection
     * @var string
     */
    public $config;

    /**
     * If this filter replaces another (like extending), note its name here
     * @var string
     */
    public $replace ;

    /**
     * The method that will be called when running the filter.
     * @var string
     */
    public $method = 'handle';

}
