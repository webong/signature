<?php

declare(strict_types=1);

namespace Webong\Signature\Tests;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Webong\Signature\Http\Middleware\RequireScopes;

final class RequireScopesTest extends TestCase
{
    public function test_it_allows_a_token_that_has_every_required_scope(): void
    {
        $request = Request::create('/contacts');
        $request->setUserResolver(fn (): object => new class {
            public function tokenCan(string $scope): bool
            {
                return in_array($scope, ['contacts:read', 'contacts:export'], true);
            }
        });

        $response = (new RequireScopes())->handle(
            $request,
            fn (): Response => new Response('ok'),
            'contacts:read',
            'contacts:export',
        );

        self::assertSame('ok', $response->getContent());
    }

    public function test_it_rejects_a_token_missing_a_required_scope(): void
    {
        $request = Request::create('/contacts');
        $request->setUserResolver(fn (): object => new class {
            public function tokenCan(string $scope): bool
            {
                return false;
            }
        });

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        (new RequireScopes())->handle(
            $request,
            fn (): Response => new Response('ok'),
            'contacts:read',
        );
    }
}
