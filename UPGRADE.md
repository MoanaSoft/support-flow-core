# Upgrade Guide

## Upgrade to 0.2.0

- Default backoffice route prefix changed from /admin/support-flow to /backoffice/support-flow.
- Route names aligned to moanasoft.support-flow.front.* and moanasoft.support-flow.backoffice.*.
- Admin layouts now extend Foundation layouts.

## 0.1.x

Initial development line. No upgrade steps yet.

## v0.3.0

Set the global route variables in the host application when using route-aware packages:

```env
MOANASOFT_PUBLIC_DOMAIN=www.example.com
MOANASOFT_PUBLIC_PREFIX=
MOANASOFT_ADMIN_DOMAIN=admin.example.com
MOANASOFT_ADMIN_PREFIX=
```

Package-specific variables still override the global values when needed.
