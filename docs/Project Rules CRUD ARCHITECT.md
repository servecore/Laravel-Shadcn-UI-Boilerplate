# Prompt: Project Rules — CRUD Architecture (Laravel + JavaScript)

## Role
Kamu adalah **Senior Full-Stack Laravel Developer** yang bertugas menyusun **coding standard / project rule** untuk fitur CRUD berbasis JavaScript di folder `resources/js`. Standar ini akan dijadikan **template reusable** yang dipakai di banyak project berbeda, jadi harus generic, konsisten, dan mudah di-maintain.

## Context
- Framework: Laravel 13+
- Frontend: Blade + JavaScript Axios
- Styling: anda Cek css atau framework pada project ini dan dengan dukungan dark mode & light mode
- Autentikasi/permission sudah ada, fokus prompt ini hanya di layer CRUD + UI interaktif

## Goal
Buatkan **dokumentasi coding standard** beserta **contoh implementasi kode (boilerplate)** untuk pola CRUD yang bisa langsung di-copy dan disesuaikan (ganti nama entity/model) di project baru, mencakup poin-poin berikut:

### 1. Struktur Folder JavaScript
- Susun struktur folder di `resources/js` per modul/entity (contoh: `resources/js/modules/{entity}/`)
- Setiap entity punya file dengan tanggung jawab jelas: `list.js`, `create.js`, `store.js`, `edit.js`, `update.js`, `destroy.js`
- Jelaskan fungsi & isi masing-masing file, serta bagaimana file-file ini saling terhubung (misal lewat event listener atau module export/import)

### 2. Reusable Modal Component
- Buat satu komponen modal generic yang bisa dipakai untuk 3 aksi: **create**, **edit**, dan **delete**
- Modal harus menerima konfigurasi dinamis (judul, isi form/field, tombol aksi) tanpa duplikasi markup
- Jelaskan cara inject konten form ke dalam modal secara dinamis (misal via template literal, Blade component slot, atau fetch partial view)

### 3. Sistem Toast Notification
- Toast dipakai untuk menampilkan feedback aksi (success, error, warning, info)
- Posisi toast (top-right, top-left, bottom-right, dst.) **harus bisa dikonfigurasi oleh admin** melalui halaman **Theme Settings**, disimpan di database, lalu dibaca oleh JS saat inisialisasi
- Jelaskan alur data: `settings table` → `endpoint/blade config` → `JS init toast dengan posisi sesuai setting`

### 4. Modal Konfirmasi Delete
- Sebelum eksekusi `destroy`, tampilkan modal konfirmasi terpisah (bisa reuse dari komponen modal di poin 2) yang menjelaskan konsekuensi aksi hapus
- Baru lanjut request delete setelah user menekan tombol konfirmasi

### 5. Prinsip DRY & Single Source of Truth
- Tunjukkan secara konkret penerapannya, misalnya:
  - Satu file konfigurasi API/endpoint terpusat (bukan hardcode URL di tiap file)
  - Satu helper/wrapper untuk fetch/axios request (termasuk handle CSRF token & error response secara seragam)
  - Satu sumber untuk pesan notifikasi/validasi (tidak duplikat di banyak tempat)

### 6. UI/UX & Konsistensi Tema
- Semua komponen (modal, toast, tombol aksi) **wajib mengikuti tema aktif** (dark mode/light mode) tanpa hardcode warna
- Gunakan CSS variable atau utility class tema yang sudah ada di project, jangan bikin style baru yang bisa merusak konsistensi desain
- Sertakan transisi/animasi ringan agar interaksi terasa halus dan modern

### 7. Keamanan & Error Handling
- Pastikan setiap request menyertakan CSRF token
- Tangani response error (validasi 422, unauthorized 403, server error 500) secara seragam lewat toast
- Sanitasi input dasar di sisi frontend sebelum submit

## Output yang Diharapkan
1. Dokumen coding standard dalam format markdown (folder structure, penjelasan tiap file, flow diagram sederhana jika perlu)
2. Contoh kode implementasi lengkap untuk **satu entity contoh** (misal `Product`) sebagai template: `list.js`, `create.js`, `store.js`, `edit.js`, `update.js`, `destroy.js`, komponen modal, dan integrasi toast
3. Catatan/komentar di kode yang menjelaskan bagian mana yang perlu disesuaikan (`// TODO: ganti sesuai entity`) saat dipakai di project/entity lain

## Constraint
- Jangan mengubah struktur tema/layout yang sudah ada
- Kode harus modular agar mudah di-reuse tanpa copy-paste berlebihan antar entity
- Gunakan penamaan variabel/fungsi yang konsisten dan deskriptif (bahasa Inggris untuk kode, komentar boleh bahasa Indonesia)

Note: Jangan Lupa terapkan naming modulnya pada file controller terkait secara konsisten dan terapkan Request permodule secara terpisah seperti sekarang di semua controller, implementasikan juga terkait Service agar controller tidak gemuk. kemudian implementasikan juga enskripsi data sensitif ketika melempar ke view dan melakukan encrypt/decrypt melalui base controller.