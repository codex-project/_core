<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addons\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
final class Hook extends AbstractAnnotation
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
     * plugin method
     *
     * @var string|bool
     */
    public $plugin = false;
}
