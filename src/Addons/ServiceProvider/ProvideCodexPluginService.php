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
namespace Codex\Addons\ServiceProvider;

use Codex\Codex;

/**
 * This is the class ProvideCodexPluginService.
 *
 * @property-read \Illuminate\Foundation\Application $app
 * @mixin \Laradic\ServiceProvider\BaseServiceProvider
 * @package        Codex\Addons
 * @author         Radic
 * @copyright      Copyright (c) 2015, Radic. All rights reserved
 */
trait ProvideCodexPluginService
{


    /**
     * This will be merged into the default_project_config.phpdoc
     *
     * @var array
     */
    protected $project = [];

    // or
    //protected $project = 'codex-phpdoc.default_project_config';

    /**
     * This will be merged into the default_document_attributes.phpdoc
     *
     * @var array
     */
    protected $document = [];

    /**
     * Define or overide views
     *
     * @var array
     */
    protected $views = [
//        'phpdoc.document' => 'codex-phpdoc::document',
//        'phpdoc.entity'   => 'codex-phpdoc::entity',
    ];

    /**
     * Shortcut to extend Extendable classes
     *
     * @var array
     */
    protected $extend = [
//        Codex::class   => [ 'phpdoc' => Phpdoc::class ],
//        Project::class => [ 'phpdoc' => PhpdocRef::class ],
    ];

    protected $routeExclusions = [
//        'phpdoc',
    ];

    protected $codexPluginPriority = 150;

    /**
     * startMiddlewarePlugin method
     *
     * @param Application $app
     */
    protected function startProvideCodexPluginServicePlugin($app)
    {
        $this->onRegister('codex', function ($app) {
            $this->projectConfig($this->project);
            $this->documentAttributes($this->document);
            foreach ($this->views as $k => $v) {
                $this->view($k, $v);
            }
            // todo ex tend
            foreach ($this->routeExclusions as $exclusion) {
                $this->excludeRoute($exclusion);
            }

            foreach ($this->extend as $target => $extensions) {
                foreach ($extensions as $name => $extension) {
                    Codex::registerExtension($target, $name, $extension);
                }
            }
        });
    }

    /**
     * addons method
     *
     * @return \Codex\Addons\Addons
     */
    protected function addons()
    {
        return \Codex\Addons\Addons::getInstance();
    }

    protected function projectConfig($config, $method = 'array_replace_recursive')
    {
        $this->addons()->mergeDefaultProjectConfig($config, $method);
    }

    protected function documentAttributes($config, $method = 'array_replace_recursive')
    {
        $this->addons()->mergeDefaultDocumentAttributes($config, $method);
    }

    protected function excludeRoute($route)
    {
        $this->app[ 'config' ]->push('codex.http.ignore_project_names', $route);
    }

    protected function hook($point, $listener)
    {
        return $this->addons()->hooks->hook($point, $listener);
    }

    /**
     * codex method
     *
     * @return \Codex\Codex
     */
    protected function codex()
    {
        return $this->app->make('codex');
    }

    /**
     * Register or gets a view name
     *
     * @param string            $key
     * @param null|string|array $value
     *
     * @return string|null
     */
    protected function view($key, $value = null)
    {
        $views = $this->addons()->views;
        return $value === null ? $views->get($key) : $views->set($key, $value);
    }
}
