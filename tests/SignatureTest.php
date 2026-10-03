<?php

declare(strict_types=1);

namespace Webong\Signature\Tests;

use Webong\Signature\Signature;

final class SignatureTest extends TestCase
{
    public function test_it_resolves_permissions_implied_by_granted_scopes(): void
    {
        $signature = $this->app->make(Signature::class);
        $signature->definePermission('contacts.read', 'View contacts.');
        $signature->defineScope('contacts:read', 'Read contacts.', ['contacts.read']);

        $authorization = $signature->authorization(['contacts:read']);

        self::assertTrue($authorization->allowsScope('contacts:read'));
        self::assertTrue($authorization->allowsPermission('contacts.read'));
        self::assertFalse($authorization->allowsPermission('contacts.write'));
    }

    public function test_it_deduplicates_granted_scopes_and_permissions(): void
    {
        $signature = $this->app->make(Signature::class);
        $signature->defineScope('contacts:read', permissions: ['contacts.read']);
        $signature->defineScope('contacts:export', permissions: ['contacts.read', 'contacts.export']);

        $authorization = $signature->authorization(['contacts:read', 'contacts:export', 'contacts:read']);

        self::assertSame(['contacts:read', 'contacts:export'], $authorization->scopes);
        self::assertSame(['contacts.read', 'contacts.export'], $authorization->permissions);
    }
}
