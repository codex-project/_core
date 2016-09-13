<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Helpers;

use Codex\Codex;
use Codex\Exception\CodexException;
use Laradic\Filesystem\Filesystem;

class ThemesHelper
{
    /** @var array */
    protected $themes;
    /** @var string */
    protected $theme;
    /** @var Filesystem */
    protected $fs;
    /** @var Codex */
    protected $codex;
    /** @var string */
    protected $path;

    /**
     * ThemesHelper constructor.
     *
     * @param \Laradic\Filesystem\Filesystem $fs
     * @param \Codex\Codex                   $codex
     * @param string                         $path
     */
    public function __construct(\Laradic\Filesystem\Filesystem $fs, \Codex\Codex $codex, $path)
    {
        $this->fs    = $fs;
        $this->codex = $codex;
        $this->path  = $path;
    }


    public function set($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    public function get($theme)
    {
        $this->hasOrDie($theme);
        return $this->themes[$theme];
    }

    public function all()
    {
        return $this->themes;
    }

    public function has($theme)
    {
        return array_key_exists($theme, $this->findAll());
    }

    protected function hasOrDie($theme)
    {
        if(false === $this->has($theme)){
            throw CodexException::because("Theme [{$theme}] does not exist");
        }
        return $this;
    }

    protected function findAll($force = false)
    {
        if(null === $this->themes || true === $force){
            //$this->themes = [];
            $this->themes = $this->fs->directories($this->path);
        }
        return $this->themes;
    }
}
