---
paths:
  - 'database/migrations/**'
---

# Migrations

## UUID models need uuid foreign/morph keys
User uses HasUuids ($keyType='string', incrementing=false). Any FK referencing users.id (e.g. sessions.user_id) must be `uuid()`, not foreignId/unsignedBigInteger. Likewise the published Spatie permission migration's `model_morph_key` (model_id) in model_has_permissions/model_has_roles must be `uuid()`.
