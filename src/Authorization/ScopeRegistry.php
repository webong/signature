<?php

declare(strict_types=1);

namespace Webong\Signature\Authorization;

final class ScopeRegistry
{
    /** @var array<string, Permission> */
    private array $permissions = [];

    /** @var array<string, Scope> */
    private array $scopes = [];

    public function definePermission(string $name, string $description = ''): Permission
    {
        return $this->permissions[$name] = new Permission($name, $description);
    }

    /** @param list<string> $permissions */
    public function defineScope(string $name, string $description = '', array $permissions = []): Scope
    {
        return $this->scopes[$name] = new Scope($name, $description, array_values($permissions));
    }

    public function permission(string $name): ?Permission
    {
        return $this->permissions[$name] ?? null;
    }

    public function scope(string $name): ?Scope
    {
        return $this->scopes[$name] ?? null;
    }

    /** @param list<string> $grantedScopes */
    public function authorization(array $grantedScopes): Authorization
    {
        $permissions = [];

        foreach ($grantedScopes as $scopeName) {
            $scope = $this->scope($scopeName);

            if ($scope !== null) {
                $permissions = [...$permissions, ...$scope->permissions];
            }
        }

        return new Authorization(
            array_values(array_unique($grantedScopes)),
            array_values(array_unique($permissions)),
        );
    }
}
