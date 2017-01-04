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
namespace Codex\Tests;

class CodexTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }


    public function test_test()
    {
        $this->assertTrue(true);
    }

    public function test_extensions()
    {
        $this->assertInstanceOf('Codex\Addons\Addons', $this->codex->addons);
        $this->assertInstanceOf('Illuminate\Events\Dispatcher', $this->app[ 'events' ]);
    }

    public function test_get_returns()
    {
        $this->assertInstanceOf('Codex\Projects\Projects', $this->codex->get('*'));
        $this->assertInstanceOf('Codex\Projects\Project', $this->codex->get('!'));
        $this->assertInstanceOf('Codex\Projects\Project', $this->codex->get('codex'));
        $this->assertInstanceOf('Codex\Projects\Refs', $this->codex->get('!/*'));
        $this->assertInstanceOf('Codex\Projects\Ref', $this->codex->get('!/!'));
        $this->assertInstanceOf('Codex\Projects\Ref', $this->codex->get('codex/master'));
        $this->assertInstanceOf('Codex\Documents\Documents', $docs = $this->codex->get('!/!::*'));
        $this->assertInstanceOf('Codex\Documents\Document', $this->codex->get('!/!::index'));
        $this->assertInstanceOf('Codex\Documents\Document', $this->codex->get('codex/master::index'));
    }
}
