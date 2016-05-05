<?php
namespace Codex\Core\Addons\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Theme
{
    /**
     * @Required()
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $method = 'views';


    /**
     * @var string|bool
     */
    public $replace = false;

}
