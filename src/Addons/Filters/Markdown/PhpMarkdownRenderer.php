<?php
namespace Codex\Addons\Filters\Markdown;

use Illuminate\Contracts\Support\Arrayable;
use Michelf\Markdown;

/**
 * Parsedown filter
 *
 * @package   Codex\Core
 * @author    Codex Project Dev Team
 * @copyright Copyright (c) 2015, Codex Project
 * @license   https://tldrlegal.com/license/mit-license MIT License
 *
 */
class PhpMarkdownRenderer implements RendererInterface
{
    protected $markdown;

    public function __construct(Markdown $markdown)
    {
        $this->markdown = $markdown;
    }


    /**
     * render method
     *
     * @param $string
     *
     * @return mixed
     */
    public function render($string)
    {
        return $this->markdown->transform($string);
    }

    /**
     * setConfig method
     *
     * @param array|Arrayable $config
     *
     * @return mixed
     */
    public function setConfig($config = [ ])
    {
        foreach ( $config as $key => $value ) {
            $this->markdown->{$key} = $value;
        }
    }

    public function getName()
    {
        return 'phpmarkdown';
    }
}
