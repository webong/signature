# Signature Identity

Signature is the shared identity and authorization vocabulary used by embedded
Laravel applications and the standalone Signature server.

## Identity

**Identity**:
A principal recognized by Signature. An identity is either a human or a machine.
_Avoid_: User, account, actor

**Human identity**:
An identity representing a person who authenticates interactively.
_Avoid_: User, customer

**Machine identity**:
An identity representing a non-human caller, such as a service or automation.
_Avoid_: Bot, robot, service account

## Authorization

**Scope**:
A named capability granted to a credential, usually through OAuth or an API token. A scope may imply one or more permissions.
_Avoid_: Role, entitlement

**Permission**:
An application-level action that may be performed on a resource.
_Avoid_: Scope, privilege

**Authorization**:
The effective scopes and permissions held by one identity for a request.
_Avoid_: Authentication, login

**Credential authority**:
The component that authenticates an identity and issues or validates its credential. Passport and Sanctum are credential authorities; Signature is not.
_Avoid_: Identity provider

## Federation and provisioning

**Single sign-on (SSO)**:
Authentication through a trusted identity authority that lets an identity access multiple relying applications without separately authenticating to each one.
_Avoid_: Shared session, delegated authorization

**Relying application**:
An application that delegates authentication to Signature or another identity authority and consumes the resulting identity claims.
_Avoid_: Client, consumer

**Directory**:
The managed collection of identities and groups for one organization.
_Avoid_: User table, tenant

**Provisioning**:
The lifecycle management of directory records, including creating, updating, deactivating, and synchronizing identities and groups.
_Avoid_: Authentication, authorization

**SCIM**:
The standard protocol used to provision and synchronize directory identities and groups.
_Avoid_: User import, SSO
