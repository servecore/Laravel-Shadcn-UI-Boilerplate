---
paths:
  - 'app/Http/Controllers/**'
---

# Controllers

## Server-side list filtering with preserved pagination
List filtering pattern (best practice): server-side filter via query params, tidak pernah filter di JS. Service punya metode seperti UserService::paginateFiltered(array $filters) dengan ->when() + LIKE, ternary status, dan ->withQueryString() agar pagination mempertahankan filter. Controller meneruskan request->only(['search','status']). Frontend membangun URL query (searchUrl()) dan memanggil loadHtml/reload; kontrol filter pakai id yang stabil (#user-search, #user-status) & native <select> (andal, bukan komponen listrik select).
