<?php

declare(strict_types=1);

namespace Webong\Signature\Facades;

use Illuminate\Support\Facades\Facade;

class Signature extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'signature';
    }
}
