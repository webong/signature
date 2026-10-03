<?php

declare(strict_types=1);

namespace Webong\Signature\Authorization;

final readonly class Scope
{
    /** @param list<string> $permissions */
    public function __construct(
        public string $name,
        public string $description = '',
        public array $permissions = [],
    ) {
    }
}
