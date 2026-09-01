# Rencana: Audit Kesiapan Extract Setup Wizard Menjadi Package

> Status: **RENCANA / PLAN** — inventori & skor keterikatan **sudah terverifikasi langsung dari pembacaan kode** (lihat kolom Status di §3); langkah eksekusi/refactor & keputusan final **belum dilakukan**.
> Tujuan: memetakan apakah wizard setup starter kit dapat diekstrak menjadi **package internal private** (disimpan & di-push ke GitHub, lalu dipasang ulang di starter kit ini) tanpa memecah arsitektur.

## 1. Konteks & Keputusan

- Keputusan sebelumnya (direkam di `.ai/rules/routes.md`): route `/setup/*` **tetap terdaftar** tapi dikunci middleware (`setup` + `guest`) → redirect ke `/dashboard` setelah `.setup-complete` ada. **Bukan dihapus**.
- Keputusan extract: **belum diekstrak**. Hanya **satu proyek** (starter kit ini) yang memakai pola wizard. Tanda sehat untuk extract = 2+ proyek dengan pola sama yang butuh sinkronisasi fix.
- Dokumen ini adalah **rencana audit** — langkah, kriteria, dan daftar ketergantungan yang akan diperiksa saat eksekusi nanti.

## 2. Tujuan Audit

Menjawab satu pertanyaan: **bisakah wizard setup diekstrak sebagai package private tanpa memecah starter kit ini, dan berapa effort yang dibutuhkan?**

Audit akan menilai 3 dimensi:
1. **Kebocoran dependency** — seberapa banyak kode wizard bergantung pada app ini (bukan generic Laravel).
2. **Level abstraksi** — mana yang sudah generic (siap extract) vs masih kaku (perlu di-abstract-kan).
3. **Kontrak & konfigurasi** — apa yang harus disediakan package (service provider, config publish, route publish, dll).

**Status audit:** dimensi 1 & 2 (kebocoran + level abstraksi) **selesai** — setiap file di §3 dibaca langsung dan diberi skor Low/Med/High + status `verified`. Dimensi 3 (kontrak & API package, §4B) masih rekomendasi desain, belum diimplementasi.

## 3. Inventori Kode Wizard (terverifikasi langsung)

> Kolom **Status** menandai sumber penilaian: `verified` = berdasarkan pembacaan langsung isi file; `assumed` = belum dibaca, hanya dugaan (harus diverifikasi saat eksekusi). **Semua baris di bawah saat ini `verified`** — inventori dituntaskan dengan pembacaan kode sebelum dokumen ini dianggap matang.

### Services (`app/Services/Setup/`)
| File | Peran | Keterikatan | Status |
|------|-------|-------------|--------|
| `SetupState.php` | Marker `.setup-complete` + state file `.setup-state` | **Low** — murni file I/O di `base_path()`, tanpa model host | ✅ verified |
| `EnvironmentChecker.php` | Cek PHP version, extension, permission, `.env`, APP_KEY | **Low** — semua requirement dari `config('setup.*')` + PHP globals; tanpa model host | ✅ verified |
| `PermissionChecker.php` | Cek writable direktori (octal bit) | **Low** — generic; folder list dari `config('setup.permissions')` | ✅ verified |
| `EnvFileManager.php` | Tulis/update `.env` + generate APP_KEY | **Low-Med** — generic `.env` parse/tulis; baca `config('setup.auto_generate_app_key')`; hardcode key `LOG_LEVEL`/`SESSION_DRIVER` sbg anchor | ✅ verified |
| `DatabaseConfigurator.php` | Bangun koneksi DB dari request | **Low-Med** — generic; pakai `database_path()` (host) utk sqlite, `search_path`/charset spesifik driver | ✅ verified |

### Form Requests (`app/Http/Requests/Setup/`)
| File | Peran | Keterikatan | Status |
|------|-------|-------------|--------|
| `SetupAdminRequest.php` | Validasi akun admin + authorize | **Med** — `unique:users,username/email` (terikat schema `users` host); `authorize()` → `!isSetup()` | ✅ verified |
| `SetupAppConfigRequest.php` | Validasi app config + authorize | **Low** — pure validation; `authorize()` → `!isSetup()` | ✅ verified |
| `SetupDatabaseRequest.php` | Validasi DB + authorize | **Low** — pure validation; `authorize()` → `!isSetup()` | ✅ verified |

### Controller & Route
| File | Keterikatan | Status |
|------|-------------|--------|
| `SetupWizardController.php` | **High** — `complete()`: `User::create(...)` + `(new RolePermissionSeeder)->run()` + `$user->assignRole('admin')` + `Auth::login()` + `markComplete()` + update env `CACHE_STORE`/`SESSION_DRIVER`/`QUEUE_CONNECTION` + `Artisan::call(...)`; bergantung `User` (HasUuids/SoftDeletes), RBAC Spatie, migrator host | ✅ verified |
| `routes/web.php` (group `setup.*`) | **Low-Med** — middleware `guest` + `setup`; name prefix `setup.` | ✅ verified |
| `RedirectIfNotSetup.php` | **Low-Med** — merujuk `SetupWizardController::isSetup()` (statis); redirect ke `dashboard` | ✅ verified |

### Views (`resources/views/setup/`)
| File | Keterikatan | Status |
|------|-------------|--------|
| `step1…step4.blade.php` | **Med** — semua `@extends('layouts.setup')` + komponen kit `<x-card/label/input/switch/button>`, Alpine `x-show`; layout & komponen UI **tidak ikut** di package | ✅ verified |

### Config
| File | Keterikatan | Status |
|------|-------------|--------|
| `config/setup.php` | **Low** — data murni (branding, requirement, permission, DB drivers, akun rules, auto key); kandidat `config:publish` | ✅ verified |

**Catatan verifikasi:** file yang tadinya dikira ragu (`EnvironmentChecker`, `PermissionChecker`) terbaca **Low** — tidak menyentuh model/seeders host, seluruh konsumsi berasal dari `config/*`. Titik keterikatan tertinggi justru terkonsentrasi di `SetupWizardController::complete()` + `SetupAdminRequest`.

## 4. Titik Kritis yang Harus Dikaji saat Eksekusi

### A. Contract points (di mana package harus ber-interaksi dengan app host)
1. **Model User** — wizard membuat admin (`User::create` + fields `username`/`is_active`/`created_by` + `HasUuids` + `SoftDeletes` + `assignRole('admin')`). Package butuh **callback/hook** atau **abstract contract** untuk membuat user admin, karena schema model milik host.
2. **RBAC (Spatie)** — `RolePermissionSeeder` + `assignRole('admin')` adalah kebijakan host, bukan generic installer. Package tak boleh meng-hardcode role/permission milik host.
3. **Migrasi DB** — wizard menjalankan migrasi app host (`migrator->run(database_path('migrations'))`). Package hanya *trigger*, location migrasi milik host.
4. **Auth login** — `Auth::login($user)` pasca-setup. Standard Laravel, aman.
5. **File marker** — `.setup-complete` / `.setup-state` di `base_path()`. Perlu dipastikan tidak bertabrakan dengan proyek lain.

### B. API yang harus diekspos package (jika extract)
- `Config::publish` → `config/setup.php` (dengan namespace package).
- `Migratable` — tidak ada migrasi milik package (schema user milik host).
- `View::publish` → template setup (agar host bisa override).
- `Routes` → method static `SetupRoutes::routes()` (bukan auto-load tak terkondisi).
- Kontrak/interface: `AdminAccountFactory` / `PostSetupHook` untuk inject logika host (RBAC seeding, dsb).

### C. Kriteria siap extract (checklist)
- [ ] 2+ proyek memakai pola setup serupa.
- [ ] Tidak ada referensi langsung ke `App\Models\User` / `Database\Seeders` dari dalam logika core wizard (harus lewat kontrak).
- [ ] RBAC & seeding admin bisa dikonfigurasi/di-inject, bukan hardcode.
- [ ] Views setup tidak bergantung pada komponen UI spesifik host (atau suda dipublish/override-able).
- [ ] Konfigurasi DB/`users` schema di-abstract-kan.
- [ ] Test package berdiri sendiri (tidak perlu app host penuh).

## 5. Opsi Strategi (untuk diputuskan saat eksekusi)

| Opsi | Deskripsi | Kapan |
|------|-----------|-------|
| **A. Tetap kode starter kit** | Wizard melekat di kit. Tidak ada refactor. | Sekarang (default). |
| **B. Refactor internal dulu** | Pisahkan logika host vs generic dalam app (kontrak + hook) tanpa membuat package. Mempermudah extract kelak. | Kalau mau menyiapkan extract bertahap. |
| **C. Extract package private** | Pindah ke repo terpisah, `composer require-vcs` / `path` repo, pasang balik. | Setelah 2+ proyek & audit lulus. |

**Rekomendasi awal:** mulai dari **B** (refactor internal ringan: pisahkan AdminAccountFactory + RBAC hook) agar opsi C lebih murah nanti. Eksekusi C ditunda sampai syarat checklist terpenuhi.

## 6. Risiko & Mitigasi

| Risiko | Mitigasi |
|--------|----------|
| Over-abstraksi dini (YAGNI) karena 1 proyek | Tunda extract; hanya pisahkan titik kontrak paling jelas. |
| Package melekat ke RBAC/Spatie host | Expose hook `PostSetupHook`; host mengimplementasi kebijakan role/permission. |
| Schema `users` berbeda antar proyek | Gunakan kontrak `AdminAccountFactory`, jangan `User::create` langsung di core. |
| Views bergantung komponen UI kit | `view:publish` + dokumentasi override; simpan default rendering minimal. |
| File marker `.setup-*` bentrok | Namespace path konfigurable via config publish. |
| Perlu `laravel-permission` ikut ter-install | Jadikan require optional di Composer (`suggest` + guard di runtime). |

## 7. Output Audit (yang akan dihasilkan saat eksekusi)

1. Matriks keterikatan tiap file (dari inventori di atas) — **Low / Med / High** + alasan.
   - **SELESAI** — lihat §3 (semua baris `verified`).
2. Daftar titik kontrak (A) dengan rekomendasi API package.
3. Skor checklist kesiapan (C).
4. Estimasi effort: refactor internal (B) vs extract penuh (C).
5. Rekomendasi akhir + langkah implementasi bertahap.

> Item 1 sudah selesai; item 2–5 adalah sisa yang dikerjakan saat eksekusi audit.

## 8. Referensi

**File kode yang diaudit (§3):**
- `app/Services/Setup/SetupState.php`
- `app/Services/Setup/EnvironmentChecker.php`
- `app/Services/Setup/PermissionChecker.php`
- `app/Services/Setup/EnvFileManager.php`
- `app/Services/Setup/DatabaseConfigurator.php`
- `app/Http/Requests/Setup/SetupAdminRequest.php`
- `app/Http/Requests/Setup/SetupAppConfigRequest.php`
- `app/Http/Requests/Setup/SetupDatabaseRequest.php`
- `app/Http/Controllers/SetupWizardController.php`
- `app/Http/Middleware/RedirectIfNotSetup.php`
- `routes/web.php` (group `setup.*`)
- `resources/views/setup/step1…step4.blade.php` + `resources/views/layouts/setup.blade.php`
- `config/setup.php`

**Rekaman keputusan project (.ai/rules):**
- `.ai/rules/routes.md` — decision route `/setup` dikunci middleware, tidak dihapus
- `.ai/rules/middleware.md` — peringatan 403 wizard + penggunaan middleware `setup`
- `.ai/rules/migrations.md` — UUID morph keys / konvensi migrasi
- `.ai/rules/bootstrap.md` — registrasi alias middleware Spatie

**Dokumentasi lain:**
- `docs/ARCHITECTURE.md`
- `docs/CONFIGURATION.md`
