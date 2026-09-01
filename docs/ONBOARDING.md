# On-Ramp untuk Developer Baru

Panduan cepat memahami & berkontribusi di starter kit ini. Baca ini sebelum ngoding UI/templating.

## 1. Gambaran arsitektur frontend

Stack: **Blade (server-rendered) + Tailwind CSS v4 + Alpine.js v3**, di-bundle oleh **Vite**.

- **BUKAN SPA** — tidak ada Vue/React/Inertia. Setiap request render halaman Blade penuh di server.
- Seluruh UI = file `.blade.php`.
- Interaktivitas kecil (dropdown, tabs, carousel, theme) pakai **Alpine.js**.

```
Request → Route (routes/web.php)
        → Controller (app/Http/Controllers/)
        → View Blade (resources/views/pages/...)
```

## 2. Peta folder penting

| Folder | Isi |
|--------|-----|
| `resources/views/layouts` | Layout dasar: `app.blade.php` (dash, pakai sidebar), `guest.blade.php` (login), `setup.blade.php` (wizard). Sidebar di `layouts/partials/sidebar/` |
| `resources/views/pages` | Halaman per fitur: `dashboard/`, `users/`, `settings/` |
| `app/View/Components` | **63 komponen Blade `x-*`** (Button, Card, Input, Select, ...). Ini inti styling |
| `resources/views/components` | Template Blade milik tiap komponen `x-*` |
| `resources/views/setup` | Halaman wizard setup (step1–4) |
| `resources/js/components` | Logika Alpine per komponen (accordion, carousel, dll) |
| `config/setup.php` | Konfigurasi wizard setup |
| `app/Services/Setup` | Logika setup (env, DB, state) — hindari ubah kecuali perlu |

## 3. Cara menambah halaman baru (paling umum)

1. **Route** — `routes/web.php`:
```php
Route::middleware(['auth', 'setup'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
```
> Catatan: `/setup/*` punya grup sendiri; aplikasi normal pakai middleware `setup` (redirect ke wizard bila belum setup).

2. **Controller** — `app/Http/Controllers/ReportController.php`, method `index()`:
```php
public function index(): View
{
    return view('pages.reports.index', ['reports' => Report::all()]);
}
```

3. **View** — `resources/views/pages/reports/index.blade.php`:
```blade
@extends('layouts.app')

@section('header', 'Laporan')

@section('content')
<div class="space-y-6">
    <x-card>
        <x-card-header>
            <x-card-title>Laporan</x-card-title>
        </x-card-header>
        <x-card-content>
            {{-- isi halaman --}}
        </x-card-content>
    </x-card>
</div>
@endsection
```

4. **(Opsional) sidebar** — tambah tautan di `resources/views/layouts/partials/sidebar/sidebar-menu.blade.php`.

## 4. Komponen `x-*`: cara pakai

Komponen di-invoke dengan `<x-nama>`. Dari `app/View/Components/Button/Button.php` → `<x-button>`, `Card/` → `<x-card>`, dst.

```blade
{{-- Tombol --}}
<x-button variant="outline" href="{{ route('users.index') }}">Teks</x-button>

{{-- Input + Label --}}
<x-label for="name">Nama</x-label>
<x-input id="name" name="name" value="{{ old('name') }}" />
```

**Variant umum yang sering dipakai:** `default`, `outline`, `destructive`, `ghost` (tergantung komponen).

Mau tahu variant yang valid? Buka template komponen di `resources/views/components/<nama>/` atau konstruktor PHP-nya.

## 5. Blade vs Alpine — dua sintaks yang beda

File Blade bisa berisi **dua bahasa** yang mirip tapi beda makna:

| Ini | Bahasa | Makna |
|-----|--------|-------|
| `{{ $name }}` | Blade | Echo variabel PHP |
| `@if / @foreach / @extends` | Blade | Direktif server |
| `x-data="..."` | Alpine | Buka state komponen JS |
| `x-show="open"` / `@click` | Alpine | Direktif JS klien |
| `@click` | Alpine | Event JS (bukan `@php`!) |

Jebakan umum developer baru: **`@` dipakai dua-duanya**. `@click` = Alpine (JS), sedangkan `@php`/`@if` = Blade (server). Kalau salah konteks, hasilnya error aneh.

## 6. Directive penting yang dipakai

- `@extends('layouts.app')` + `@section('content')` — struktur halaman.
- `@can('manage users')` / `@endcan` — cek permission Spatie (sembunyikan tombol/admin).
- `@auth` / `@guest` — cek login.
- `route('...')` — buat URL pakai nama route (jangan hardcode).

## 7. Rule of thumb: apakah tag ini render server atau klien?

Aturan praktis: **kalau butuh data PHP / auth / database → Blade; kalau reaksi murni di halaman (buka tutup, geser, tab) tanpa data server → Alpine.**

## 8. Menjalankan di lokal

```bash
composer install
cp .env.example .env          # lalu isi .env
php artisan key:generate
php artisan migrate --seed
bun install                    # atau npm install
bun run dev                    # vite dev server (HMR)
```

Kalau frontend berubah tapi tidak kelihatan di browser → cek `bun run dev` berjalan, atau `bun run build` untuk produksi.

## 9. Checklist sebelum commit kode UI

- [ ] Pintasan ke route pakai `route('...')`, jangan path mentah.
- [ ] Gunakan komponen `x-*` yang ada, jangan nulis HTML + class CSS manual berulang.
- [ ] Tombol/aksi admin dibungkus `@can(...)`.
- [ ] Setiap perubahan file `/resources/views` bisa langsung terlihat via `bun run dev`.
- [ ] Perubahan PHP: jalankan `vendor/bin/pint` di file yang diubah.

## 10. Baca juga

- `docs/ARCHITECTURE.md` — struktur inti.
- `docs/CONFIGURATION.md` — pengaturan app.
- Daftar folder komponen: `app/View/Components/*`.
- Logika JS Alpine: `resources/js/app.js`.

---

## Lampiran A. Cheat-sheet komponen `x-*` (63 komponen)

Nama komponen = nama kelas + lokasi di `app/View/Components/*`. Template Blade-nya ada di `resources/views/components/*`.

> Semua komponen menerima atribut HTML biasa (`id`, `class`, `name`, ...) dan di-forward ke elemen root. Nilai default otomatis jika tidak dilempar.

### Umum (`theme`, `variant`, `size`)

Dua tema global: **`default`** (rounded-full, ring-offset) dan **`New York`** (rounded-md, lebih flat/compact).

### Button — `<x-button>`
| Param | Nilai |
|-------|-------|
| `theme` | `default`, `New York` |
| `variant` | `default`, `destructive`, `outline`, `secondary`, `ghost`, `link` |
| `size` | `default`, `sm`, `lg`, `icon` |
| lain | `asChild` (bool), `loading` (bool, muncul spinner) |

```blade
<x-button variant="outline" href="{{ route('users.index') }}">Teks</x-button>
<x-button variant="destructive" size="sm">Hapus</x-button>
```
> `href` dipakai → komponen render sebagai link (`<a>`), tanpa `href` = `<button>`.

### Badge — `<x-badge>`
| Param | Nilai |
|-------|-------|
| `theme` | `default`, `New York` |
| `variant` | `default`, `destructive`, `outline`, `secondary` |

```blade
<x-badge variant="destructive">Error</x-badge>
<x-badge variant="outline">Draft</x-badge>
```

### Alert — `<x-alert>`
| Param | Nilai |
|-------|-------|
| `theme` | `default`, `New York` |
| `variant` | `default`, `destructive` |

Sub-komponen: `<x-alert-title>`, `<x-alert-description>`.
```blade
<x-alert variant="destructive">
    <x-alert-title>Perhatian</x-alert-title>
    <x-alert-description>Data belum tersimpan.</x-alert-description>
</x-alert>
```

### Card — `<x-card>`
| Param | Nilai |
|-------|-------|
| `theme` | `default`, `New York` |

Sub-komponen: `<x-card-header>`, `<x-card-title>`, `<x-card-description>`, `<x-card-content>`, `<x-card-footer>`.
```blade
<x-card>
    <x-card-header><x-card-title>Judul</x-card-title></x-card-header>
    <x-card-content>...</x-card-content>
</x-card>
```

### Input & Label
```blade
<x-label for="name">Nama</x-label>
<x-input id="name" name="name" value="{{ old('name') }}" />
```
`<x-label>` param: `for` (string|null). `<x-input>` hanya `theme`.

### Form: Checkbox / RadioGroup / Select / Tabs / Accordion / Dialog / Collapsible
| Komponen | Param penting |
|----------|---------------|
| `<x-checkbox>` | `checked` (bool\|string\|null), `value` ('on'), `disabled`, `required`; sub: `<x-checkbox-indicator>` |
| `<x-radio-group>` | `value`, `orientation`, `required`, `disabled`; sub: `<x-radio-group-item value="...">`, `<x-radio-group-indicator>` |
| `<x-select>` | `placeholder`, `value`, `name`, `disabled`; sub: `<x-select-trigger>`, `<x-select-value placeholder="...">`, `<x-select-content>`, `<x-select-item value="...">` |
| `<x-tabs>` | `defaultValue`, `orientation`, `theme`; sub: `<x-tabs-list>`, `<x-tabs-trigger value="...">`, `<x-tabs-content value="...">` |
| `<x-accordion>` | `type` ('single'/'multiple'), `collapsible`, `value`, `direction`; sub: `<x-accordion-item value="...">`, `<x-accordion-trigger>`, `<x-accordion-content>` |
| `<x-dialog>` | `open`, `theme`; sub: `<x-dialog-trigger>`, `<x-dialog-content>`, `<x-dialog-header>`, `<x-dialog-title>`, `<x-dialog-description>`, `<x-dialog-footer>`, `<x-dialog-close>` |
| `<x-collapsible>` | `open`, `disabled`; sub: `<x-collapsible-trigger>`, `<x-collapsible-content>` |

### Lain-lain
| Komponen | Param penting | Kegunaan |
|----------|---------------|----------|
| `<x-avatar>` | `theme`; sub: `<x-avatar-image>`, `<x-avatar-fallback delay="0">` | Foto profil |
| `<x-breadcrumb>` | `theme`; sub: `<x-breadcrumb-list>`, `<x-breadcrumb-item>`, `<x-breadcrumb-link>`, `<x-breadcrumb-page>`, `<x-breadcrumb-separator>`, `<x-breadcrumb-ellipsis>` | Navigasi jejak |
| `<x-carousel>` | `orientation`, `options` (array), `plugins` (array); sub: `<x-carousel-content>`, `<x-carousel-item>`, `<x-carousel-previous>`, `<x-carousel-next>` | Carousel (embla) |
| `<x-aspect-ratio>` | `ratio` (float, default 1) | Menjaga rasio |
| `<x-progress>` | `value` (0–`max`), `max` (100), `theme` | Bar kemajuan |

### Khusus setup (hanya dipakai di `resources/views/setup/*`)
`<x-setup-input>`, `<x-setup-select>`, `<x-setup-error>`.

### Komponen internal (jangan dipakai manual)
`<x-compile-as-child>` — dipakai komponen dengan `asChild` untuk me-merge atribut ke child element. Jangan dipanggil langsung.

---

## Lampiran B. Cara cek variant/layout realistis

Karena variant bisa berubah, cara tercepat & paling akurat:
1. Buka template: `resources/views/components/<nama>/<nama>.blade.php`.
2. Lihat blok `@php ... $attributes->class([...])`.
3. Baris `'...' => $variant === 'apa'` = nilai variant yang valid.

Atau lihat konstruktor: `app/View/Components/<Nama>/<Nama>.php` → `public function __construct(...)`.
