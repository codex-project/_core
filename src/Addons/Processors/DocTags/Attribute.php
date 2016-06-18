<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/11/16
 * Time: 9:20 AM
 */

namespace Codex\Addons\Processors\DocTags;




class Attribute
{
    /** @var \Codex\Documents\Document */
    public $document;

    /** @var \Codex\Projects\Project */
    public $project;


    public function printValue($isCloser = false, $key, $default = null)
    {
        return $this->document->attr($key, $default);
    }
}
