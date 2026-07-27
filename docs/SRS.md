# SRS — Modernisasi JARSIPLUS 2026

**Dokumen**: Software Requirements Specification
**Produk**: JARSIPLUS
**Versi dokumen**: 1.0
**Tanggal**: 2026-07-27
**Rujukan**: PRD.md

---

## 1. Pendahuluan

### 1.1 Tujuan
Menjabarkan kebutuhan fungsional dan non-fungsional teknis untuk modernisasi JARSIPLUS:
upgrade Laravel/PHP, rebuild frontend ke Inertia + Vue 3, penghapusan PWA, pembersihan
SIKERJA, dan penghapusan penjurian Beimbai — dengan menjaga panel admin Nue.

### 1.2 Lingkup sistem
Satu aplikasi Laravel (modular, nwidart/laravel-modules) yang melayani:
- Frontend publik & pemohon (akan berbasis **Inertia + Vue 3**).
- Panel admin staf (tetap **Blade + Nue**).
Kedua paradigma render berdampingan dalam satu app.

### 1.3 Definisi
- **Permohonan**: pengajuan inovasi oleh pemohon.
- **Indikator / Parameter**: kriteria penilaian.
- **Bukti dukung / Berkas**: file pendukung per indikator.
- **Pembahasan**: diskusi/validasi antara pemohon & verifikator.
- **Penilaian**: skoring oleh admin/juri.
- **Beimbai**: alur permohonan paralel kedua (penilaiannya dihapus di rilis ini).

---

## 2. Arsitektur Target

### 2.1 Gambaran
```
Browser
  ├── Route publik/pemohon  → Controller → Inertia::render() → Vue 3 page (Vite)
  └── Route e-panel (admin)  → Controller → view() Blade (Nue)  [DIJAGA]

Laravel 12 (PHP 8.3)
  ├── Modules: Core, Formulir, Pemohon, Template, Wilayah, Faq
  ├── Auth: SSO (novay/sso-client) → sso.samarindakota.go.id
  ├── DB primer: jarsiplus_main (MySQL)
  ├── DB sekunder: mysql_iks (data wilayah/geo)
  └── Realtime: pembahasan (Reverb/Echo atau socket.io — lihat 6.3)
```

### 2.2 Koeksistensi Inertia + Blade
- Middleware `HandleInertiaRequests` hanya membungkus grup route publik/pemohon.
- Root Blade `resources/views/app.blade.php` untuk mount aplikasi Vue.
- Grup route e-panel (`epanel.*`) tetap mengembalikan Blade Nue tanpa perubahan.
- Vite mengelola aset frontend baru; aset admin Nue dibiarkan pada mekanisme lama.

### 2.3 Modul & kepemilikan
| Modul | Peran | Perubahan |
|---|---|---|
| Template | Frontend publik + pemohon | Rebuild ke Inertia/Vue |
| Formulir | Logika permohonan, indikator, penilaian, Beimbai | Upgrade; hapus Beimbai penilaian |
| Core | File, pembahasan, validasi, penjadwalan, slider, laman | Upgrade; jaga admin |
| Pemohon | Data pemohon & korporasi | Upgrade |
| Wilayah | Master provinsi/kota | Upgrade |
| Faq | FAQ | Upgrade |

---

## 3. Kebutuhan Fungsional

### 3.1 Publik (Inertia/Vue)
- **FR-P1** Menampilkan landing page.
- **FR-P2** Halaman Informasi dari entity `Laman` (konten dinamis).
- **FR-P3** Halaman Statistik (agregat permohonan/inovasi).
- **FR-P4** Halaman FAQ.
- **FR-P5** Halaman maintenance.

### 3.2 Pemohon (Inertia/Vue, auth SSO)
- **FR-M1** Login/logout via SSO Samarinda; auto-login middleware.
- **FR-M2** Buat permohonan inovasi (form multi-segmen), simpan draft.
- **FR-M3** Kelola indikator & unggah bukti dukung/berkas per indikator.
- **FR-M4** Lihat detail permohonan.
- **FR-M5** Ikuti pembahasan (kirim/terima pesan diskusi, lampiran, realtime).
- **FR-M6** Lihat riwayat & status; kirim final; lihat persetujuan.
- **FR-M7** Kelola pengaturan akun / profil / data korporasi.

### 3.3 Admin (Blade/Nue — DIJAGA, tak diredesain)
- **FR-A1** Kelola permohonan (list, detail, status, notifikasi).
- **FR-A2** Penilaian permohonan & arsip.
- **FR-A3** Pembahasan & validasi berkas.
- **FR-A4** Penjadwalan/persetujuan (`permohonan_aprrove`).
- **FR-A5** Bukti dukung (index + export).
- **FR-A6** Master data: kategori, urusan, indikator, parameter.
- **FR-A7** Kelola pemohon, slider, laman, log permohonan.

### 3.4 Integrasi
- **FR-I1** Feed juri via API (`Api\PenjurianController`, `FetchJuriData`) — dipertahankan.
- **FR-I2** SSO broker JARSIPLUS — dipertahankan.

### 3.5 Yang dihapus
- **FR-X1** Penjurian Beimbai: `Beimbai\PenilaianController`, route `beimbai-permohonan.penilaian`,
  entity stub `Entities/Beimbai/Penilaian.php`. Base penilaian tetap.
- **FR-X2** PWA: serviceworker, manifest, paket laravelpwa, registrasi SW.
- **FR-X3** Jejak SIKERJA: prefix route `sikerja`→`jarsiplus`, aset & folder orphan.

---

## 4. Kebutuhan Non-Fungsional

- **NFR-1 Kompatibilitas**: Laravel 12 (fallback 11) + PHP 8.3 (8.4 opsional).
- **NFR-2 Keamanan**: `.env` & `database_dump.sql` keluar dari repo; rotasi APP_KEY/DB/SSO
  secret; pertahankan proteksi auth & CSRF; SSO tetap aman.
- **NFR-3 Pemeliharaan**: hapus kode mati; buat migration nyata dari dump; PSR-4 rapi.
- **NFR-4 Performa**: build Vite (code-split), hapus overhead serviceworker.
- **NFR-5 Parity**: perilaku fungsional identik versi lama; tanpa regresi.
- **NFR-6 Kompatibilitas data**: file unggahan pada path `sikerja/` tetap terbaca.

---

## 5. Model Data (ringkas)

| Entity | Tabel | Modul |
|---|---|---|
| Permohonan | `permohonan` | Formulir |
| Penilaian | `permohonan_penilaian` | Formulir |
| DataDukung/File | `permohonan_file` | Formulir/Core |
| Histori | `permohonan_histori` | Core |
| Pembahasan | `permohonan_histori_pembahasan` | Core |
| Validasi | `permohonan_histori_pembahasan_validasi` | Core |
| Penjadwalan | `permohonan_aprrove` | Core |
| Arsip | `permohonan_2024` | Formulir |
| Indikator/Parameter | `master_indikator`, `master_parameter` | Formulir |
| Urusan/Kategori | `urusan`, `urusan_kategori` | Formulir |
| Pemohon/Corporate | `pemohon`, `pemohon_corporate` | Pemohon |
| Laman/Slider | `laman`, `slider` | Core |
| Kota/Provinsi | `master_cities`, `master_provinces` | Wilayah |
| Beimbai | `beimbai_permohonan`, `master_beimbai_*` | Formulir |

Catatan: skema domain saat ini hanya ada di `database_dump.sql` (belum ada migration).
Tabel orphan (`permohonan_clone`, `permohonan_monev`) diselidiki; kemungkinan sisa SIKERJA.

---

## 6. Keputusan & Spesifikasi Teknis

### 6.1 Upgrade Laravel (bertahap 8→9→10→11→12)
Titik breaking yang harus ditangani:
- CORS: buang `fruitcake/laravel-cors` → `config/cors.php` bawaan.
- Ignition: `facade/ignition` → `spatie/laravel-ignition`.
- Helper deprecated: `str_slug`, `str_random` → facade `Str::` (lokasi: TksdController,
  Template/PermohonanController, DataController, BerkasController, Pemohon/PemohonController,
  Formulir/UrusanController, Nue/UserController, Beimbai/PermohonanController).
- Sanctum ^2→^4, Tinker ^2.9, Collision ^5→^8, PHPUnit ^9→^11.
- intervention/image ^2→^3 (API `ImageManager` baru) — sesuaikan controller unggah.
- eloquent-sluggable & nwidart/laravel-modules → versi L12.
- Struktur L11+ (`bootstrap/app.php`) — migrasi bertahap dari `Http/Kernel.php`.

### 6.2 Blocker pihak ketiga (kritis)
- **novay/nue (2.26) + nue-extensions/***: dipakai ~266× (`me()`, `notify()`, `config('nue')`).
  Bila tak ada versi L12 → fork/patch lokal via `repositories` (path/vcs). Visual admin tetap.
- **novay/sso-client (^1.0)**: SSO wajib jalan; uji `SSOAutoLogin` end-to-end; fork bila perlu.
- Bila keduanya mentok → fallback Laravel 11 (konfirmasi user).

### 6.3 Frontend Inertia + Vue 3
- Ganti Laravel Mix → Vite (`laravel-vite-plugin`, `@vitejs/plugin-vue`).
- Paket: `vue@3`, `@inertiajs/vue3`, adapter server Inertia Laravel.
- Port halaman `Modules/Template` (publik+pemohon) 1:1 ke Vue page components.
- Controller Template: `view()` → `Inertia::render()` dengan props sama.
- Styling: Tailwind (opsi) atau port CSS existing — ditetapkan di plan.

### 6.4 Realtime pembahasan
Opsi A: **Laravel Reverb + Echo** (websocket first-party L11+) — direkomendasikan.
Opsi B: pertahankan gateway socket.io existing.
Keputusan final ditetapkan sebelum Fase 3 mulai.

### 6.5 Hapus PWA
Hapus `silviolleite/laravelpwa`, `serviceworker.js`, `__manifest.json`, registrasi SW,
config PWA, dan folder orphan `public_/`.

---

## 7. Matriks Route (ringkas)

| Grup | Prefix (baru) | Render | Status |
|---|---|---|---|
| Publik | `/`, `/informasi`, `/statistik`, `/faq` | Inertia/Vue | Rebuild |
| Pemohon | `permohonan.*`, `settings.*` | Inertia/Vue | Rebuild |
| Admin e-panel | `jarsiplus/*` (dari `sikerja`), `master/*` | Blade/Nue | Dijaga |
| Beimbai | `Beimbai/*` (penilaian dihapus) | Blade/Nue | Sebagian dihapus |
| API | `api/permohonan` (feed juri) | JSON | Dipertahankan |

---

## 8. Kriteria Verifikasi (traceability ke NFR/FR)

1. `php artisan route:list`: prefix `jarsiplus/*` ada; `beimbai-permohonan.penilaian` hilang;
   `epanel.*` lain utuh. (FR-X1, FR-X3)
2. SSO login pemohon & staf sukses. (FR-M1, FR-I2, NFR-2)
3. Alur pemohon end-to-end di Vue berperilaku identik. (FR-M2..M7, NFR-5)
4. Panel admin berfungsi & tampil sama. (FR-A*, Non-goal redesain)
5. Tidak ada serviceworker/PWA; grep `sikerja` di kode = 0 (kecuali path storage sengaja).
   (FR-X2, FR-X3)
6. `composer install` + `npm run build` (Vite) sukses; test hijau. (NFR-1, NFR-3)
