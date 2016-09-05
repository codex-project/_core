<?php
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
