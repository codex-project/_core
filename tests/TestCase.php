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
namespace Codex\Tests;

use Codex\CodexServiceProvider;
use Laradic\Support\Util;
use Laradic\Testing\Laravel\AbstractTestCase;

class TestCase extends AbstractTestCase
{

    protected $isProject;

    protected function getPackageRootPath()
    {
        return __DIR__ . '/..';
    }

    /**
     * getServiceProviderClass
     *
     * @return \Laradic\ServiceProvider\ServiceProvider
     */
    protected function getServiceProviderClass()
    {
        return CodexServiceProvider::class;
    }

    public function setUp()
    {
        $this->isProject = getenv('IS_PROJECT');
        parent::setUp();

        // setup manifest
        $codexArr  = json_decode(file_get($this->fixturesPath('codex.json')), true);
        $codexArr  = Util::recursiveArrayStringReplace($codexArr, [ '{vendor_dir}' => $this->basePath('vendor') ]);
        file_put(storage_path('codex.json'), json_encode($codexArr));

        // setup log
        file_touch(storage_path('codex.log'));


        $this->registerServiceProvider();
        $this->getConfig()->set('codex.plugins', []);
    }

    protected function fixturesPath($path = null)
    {
        $fixturesPath= path_join(__DIR__, 'fixtures');
        return $path ? path_join($fixturesPath, $path) : $fixturesPath;
    }

    protected function basePath($path = null)
    {
        $basePath = preg_replace('/\/vendor\/orchestra.*/', '', realpath(base_path()));
        return $path ? path_join($basePath, $path) : $basePath;
    }
}
