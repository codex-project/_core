<?php
namespace Codex\Core\Addons\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * This is the class FilterConfig.
 *
 * @package        Codex\Core
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 * @Annotation
 * @Target({"PROPERTY","METHOD"})
 * 
 */
final class Config
{
    /**
     * The type of config eg: filter or document
     * @Required
     * @var string
     */
    public $type;

    /**
     * The name of the type. eg: if you have type = "filter" then name could be "parsedown"
     * @var string
     */
    public $name;
}
