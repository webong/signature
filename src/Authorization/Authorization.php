<?php

declare(strict_types=1);

namespace Webong\Signature\Authorization;

final readonly class Authorization
{
    /** @param list<string> $scopes @param list<string> $permissions */
    public function __construct(public array $scopes, public array $permissions)
    {
    }

    public function allowsScope(string $scope): bool
    {
        return in_array($scope, $this->scopes, true);
    }

    public function allowsPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions, true);
    }
}
