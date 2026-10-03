<?php

declare(strict_types=1);

namespace Webong\Signature\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Webong\Signature\SignatureServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [SignatureServiceProvider::class];
    }
}
