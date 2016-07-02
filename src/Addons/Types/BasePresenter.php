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

use Codex\Addons\Factory;
use Codex\Addons\Scanner\ClassFileInfo;
use Symfony\Component\Finder\SplFileInfo;

abstract class BasePresenter implements Presenter
{
    protected $annotation;

    /** @var \Symfony\Component\Finder\SplFileInfo  */
    protected $file;

    /** @var \Codex\Addons\Factory  */
    protected $factory;

    /**
     * BasePresenter constructor.
     *
     * @param $annotation
     * @param $file
     * @param $factory
     */
    public function __construct($annotation, $file)
    {
        $this->factory    = Factory::getInstance();
        $this->annotation = $annotation;
        if($file instanceof ClassFileInfo){
            $this->file = $file;
        } elseif($file instanceof SplFileInfo){

        }
        $this->file       = new SplFileInfo($file, $file, $file);

    }


}