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
namespace Codex\Addons\Types;

class Hook extends BasePresenter
{
    /** @var  \Codex\Addons\Annotations\Hook */
    protected $annotation;

    public function __construct(\Codex\Addons\Annotations\Hook $annotation, $file)
    {
        parent::__construct($annotation, $file);
    }



}