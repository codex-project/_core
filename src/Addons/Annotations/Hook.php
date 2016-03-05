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
    public $value;

    /**
     * Targets as bitmask.
     *
     * @var integer
     */
    public $points;

    /**
     * Annotation constructor.
     *
     * @param array $values
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $values)
    {
        if ( !isset($values[ 'value' ]) ) {
            $values[ 'value' ] = null;
        }
        if ( is_string($values[ 'value' ]) ) {
            $values[ 'value' ] = [ $values[ 'value' ] ];
        }

        $this->value = $values['value'];
        $this->points = $values['value'];

    }
}
