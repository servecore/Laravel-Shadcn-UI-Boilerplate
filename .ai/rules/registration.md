---
paths:
  - app/Http/Controllers/Auth/RegisterController.php
  - app/Http/Requests/Auth/**
  - app/Mail/**
  - app/Models/RegistrationInvite.php
  - resources/views/auth/register*.blade.php
---

# Registration (email-only invite flow)

## Flow
Registration is email-only. `POST /register` (+ `/register/{token}`) issues a one-time `RegistrationInvite`, emails a set-password link (`register.complete`), and only creates the `User` after the token is redeemed (name/username/password). The email address is the single point of contact; no user row exists until the link is clicked.

- `RegisterRequest` only validates `email` (required/email/lowercase) plus after-rules that reject emails already on `users` or with an active invite.
- `CompleteRegistrationRequest` validates `name`, `username` (unique:users), and `password` (confirmed, `Password::defaults()`). It has no `email` field — the email comes from the redeemed token.
- On completion: `User::create` (fillable only — do NOT put `email_verified_at`/`created_by` in the array, they aren't fillable), then `$user->markEmailAsVerified()` (not `email_verified_at` directly in create), `assignRole('user')`, delete the invite, `Auth::login`, redirect to `dashboard`.
- `created_by` is a real `users.` column but is NOT in `$fillable`; set it via `forceFill`/explicit assign if needed.
- Both register routes sit in the `guest` group, so an already-authenticated visitor is bounced by the `guest` middleware before the controller runs — don't write tests that POST register while authenticated.

## Mail
`MAIL_FROM_ADDRESS` in `.env` must be RFC-valid. With Gmail SMTP the From must equal the authenticated `MAIL_USERNAME` (Gmail only sends from addresses it owns). A malformed From (e.g. a value containing a nested `@`) makes Symfony throw `RfcComplianceException` (500). Mailable `RegistrationInviteMail` intentionally has no `from()` so it inherits `mail.from` config.
