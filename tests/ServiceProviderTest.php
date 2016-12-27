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

class ServiceProviderTest extends TestCase
{


    public function setUp()
    {
        parent::setUp();

        $this->registerServiceProvider();
    }

    public function test_path_resolving_is_correct()
    {
        $a = 'a';
    }
}
