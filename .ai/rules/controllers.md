---
paths:
  - 'app/Http/Controllers/**'
  - app/Http/Controllers/UserController.php
---

# Controllers

## Server-side list filtering with preserved pagination
List filtering pattern (best practice): server-side filter via query params, tidak pernah filter di JS. Service punya metode seperti UserService::paginateFiltered(array $filters) dengan ->when() + LIKE, ternary status, dan ->withQueryString() agar pagination mempertahankan filter. Controller meneruskan request->only(['search','status']). Frontend membangun URL query (searchUrl()) dan memanggil loadHtml/reload; kontrol filter pakai id yang stabil (#user-search, #user-status) & native <select> (andal, bukan komponen listrik select).

## User CRUD is_active toggle + self-deactivation guard
User CRUD mendukung is_active: Store/UpdateUserRequest memvalidasi is_active (sometimes|boolean). Guard update: user TIDAK boleh menonaktifkan akun sendiri (422 JSON / back withErrors), gunakan $request->has('is_active') && ! $request->boolean('is_active'). Form server-rendered memakai hidden input value 0 di depan checkbox 1 supaya unchecked = '0' terkirim.
