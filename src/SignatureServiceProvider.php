<?php

declare(strict_types=1);

namespace Webong\Signature;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Webong\Signature\Authorization\ScopeRegistry;
use Webong\Signature\Http\Middleware\RequireScopes;

final class SignatureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/signature.php', 'signature');

        $this->app->singleton(ScopeRegistry::class, function (): ScopeRegistry {
            $registry = new ScopeRegistry();

            foreach (config('signature.permissions', []) as $name => $description) {
                $registry->definePermission($name, (string) $description);
            }

            foreach (config('signature.scopes', []) as $name => $definition) {
                $registry->defineScope(
                    $name,
                    (string) ($definition['description'] ?? ''),
                    $definition['permissions'] ?? [],
                );
            }

            return $registry;
        });

        $this->app->singleton(Signature::class);
        $this->app->alias(Signature::class, 'signature');
    }

    public function boot(Router $router): void
    {
        $this->publishes([
            __DIR__.'/../config/signature.php' => config_path('signature.php'),
        ], 'signature-config');

        $router->aliasMiddleware('signature.scope', RequireScopes::class);
    }
}
