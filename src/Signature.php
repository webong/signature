<?php

declare(strict_types=1);

namespace Webong\Signature;

use Webong\Signature\Authorization\Authorization;
use Webong\Signature\Authorization\Permission;
use Webong\Signature\Authorization\Scope;
use Webong\Signature\Authorization\ScopeRegistry;

final class Signature
{
    public function __construct(private readonly ScopeRegistry $scopes)
    {
    }

    public function definePermission(string $name, string $description = ''): Permission
    {
        return $this->scopes->definePermission($name, $description);
    }

    /** @param list<string> $permissions */
    public function defineScope(string $name, string $description = '', array $permissions = []): Scope
    {
        return $this->scopes->defineScope($name, $description, $permissions);
    }

    /** @param list<string> $scopes */
    public function authorization(array $scopes): Authorization
    {
        return $this->scopes->authorization($scopes);
    }

    public function scopes(): ScopeRegistry
    {
        return $this->scopes;
    }
}
