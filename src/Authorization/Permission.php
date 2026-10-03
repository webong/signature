<?php

declare(strict_types=1);

namespace Webong\Signature\Authorization;

final readonly class Permission
{
    public function __construct(public string $name, public string $description = '')
    {
    }
}
