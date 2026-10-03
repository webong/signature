# Signature

Signature is a Laravel identity and authorization foundation. It can be embedded
in a Laravel application or used by the future standalone Signature server.

It gives Passport and Sanctum applications one shared vocabulary for human and
machine identities, OAuth scopes, and application permissions.

## Current foundation

- declare scopes and permissions in `config/signature.php`;
- resolve the permissions implied by a set of granted scopes;
- protect a route with the `signature.scope` middleware; and
- use the `Signature` facade or service to query the access model.

```php
// config/signature.php
'scopes' => [
    'contacts:read' => [
        'description' => 'Read contacts.',
        'permissions' => ['contacts.read'],
    ],
],
```

```php
Route::get('/contacts', ContactsController::class)
    ->middleware(['auth:sanctum', 'signature.scope:contacts:read']);
```

The scope middleware uses Laravel's `tokenCan()` contract, so it works with
Sanctum tokens and Passport access tokens. Passport and Sanctum remain the
credential authorities; Signature does not mint or validate tokens itself.

## Direction

Signature will support both an embedded Laravel package and a standalone
identity server. The core stays persistence- and protocol-agnostic, while
Passport, Sanctum, and standards adapters provide delivery mechanisms.

### Standards boundary

Signature will support two complementary standards:

- **SSO:** OpenID Connect built on OAuth 2.0. Signature can act as an identity
  authority for first- and third-party relying applications, and a Laravel
  application can use Signature as its relying-application integration.
- **SCIM 2.0:** directory provisioning for identities and groups. A standalone
  Signature server can expose the SCIM service-provider API; embedded Laravel
  applications can opt into the same provisioning model through a mapped local
  directory.

SSO answers “who is this caller and how did they authenticate?” SCIM answers
“which identities and groups should exist here?” They share a directory but
remain separate protocols and concerns.

See [CONTEXT.md](CONTEXT.md) for the project's canonical identity language.
