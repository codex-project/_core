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
class Processor extends AbstractAnnotation
{

    /**
     * @Required()
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $replace;

    /**
     * @deprecated
     * @var int
     */
    public $priority = 10;

    /**
     * (optional) The property name of the default configuration this filter has. During runtime, this will be replaced with the actual, processed config Collection
     * @var string
     */
    public $config;

    /**
     * The method that will be called when running the filter.
     * @var string
     */
    public $method = 'handle';

    /**
     * The processors that should be called before this filter.  Enables dependency sorting.
     * @var array
     */
    public $after = [];

    /**
     * The processors that should be called after this filter.  Enables dependency sorting.
     * @var array
     */
    public $before = [];

    /**
     * A list of processors that are required to run before this processor. If any of these is not enabled or installed, there will be an Exception saying so.
     * @var array
     */
    public $depends = [];

    /**
     * plugin method
     *
     * @var string|bool
     */
    public $plugin = false;
}
