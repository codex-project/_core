<?php
namespace Codex\Tests;

use Codex\CodexServiceProvider;
use Sebwite\Testing\Laravel\AbstractTestCase;

class TestCase extends AbstractTestCase
{

    protected function getPackageRootPath()
    {
        return __DIR__ . '/..';
    }

    /**
     * getServiceProviderClass
     *
     * @return \Sebwite\Support\ServiceProvider
     */
    protected function getServiceProviderClass()
    {
        return CodexServiceProvider::class;
    }


}