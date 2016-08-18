<?php
namespace Codex\Tests;

use Codex\CodexServiceProvider;
use Laradic\Testing\Laravel\AbstractTestCase;

class TestCase extends AbstractTestCase
{

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


}
