<?php

declare(strict_types=1);

namespace Webong\Signature\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequireScopes
{
    /** @param list<string> $scopes */
    public function handle(Request $request, Closure $next, string ...$scopes): Response
    {
        $user = $request->user();

        if ($user === null || ! method_exists($user, 'tokenCan')) {
            abort(403, 'A Signature-compatible token is required.');
        }

        foreach ($scopes as $scope) {
            if (! $user->tokenCan($scope)) {
                abort(403, sprintf('The token is missing the [%s] scope.', $scope));
            }
        }

        return $next($request);
    }
}
