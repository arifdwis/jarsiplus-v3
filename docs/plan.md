# Plan Eksekusi — Modernisasi JARSIPLUS 2026

**Rujukan**: PRD.md, SRS.md
**Versi**: 1.0
**Tanggal**: 2026-07-27

Roadmap bertahap. Tiap fase punya checklist, titik uji, dan rollback. Jangan lompat fase
sebelum uji fase sebelumnya hijau.

---

## Fase 0 — Persiapan & keamanan kerja

- [ ] Inisialisasi git (`git init`) — repo saat ini belum ter-git. Commit baseline utuh.
- [ ] Pindahkan secret keluar repo: `.env`, `database_dump.sql` → `.gitignore`. Rotasi
      APP_KEY, kredensial DB, SSO secret.
- [ ] Siapkan PHP 8.3 lokal + MySQL; jalankan app existing sebagai baseline.
- [ ] Buat **migration nyata** dari `database_dump.sql` (skema tanpa data) untuk CI/test.
- [ ] Tulis daftar **smoke test manual** alur kunci:
      login SSO (pemohon+staf), ajukan permohonan, unggah berkas, pembahasan chat,
      penilaian admin, cetak/export, statistik.

**Titik uji**: app baseline jalan; smoke test terdokumentasi.
**Rollback**: tidak relevan (belum mengubah kode).

---

## Fase 1 — Upgrade Laravel 8 → 12 + PHP 8.3

Naikkan satu major per langkah, commit tiap langkah.

- [ ] **8 → 9**: buang `fruitcake/laravel-cors` (pakai `config/cors.php`); `facade/ignition`
      → `spatie/laravel-ignition`; sesuaikan `composer.json`.
- [ ] **9 → 10**: PHP min 8.1; naikkan Sanctum, Collision, PHPUnit; cek deprecasi.
- [ ] **10 → 11**: PHP min 8.2; opsi migrasi struktur `bootstrap/app.php`.
- [ ] **11 → 12**: naikkan seluruh paket ke rilis L12; set PHP target 8.3.
- [ ] Refactor helper deprecated `str_slug`/`str_random` → `Str::slug()`/`Str::random()`
      (lihat SRS 6.1 untuk daftar lokasi).
- [ ] intervention/image v2 → v3: sesuaikan pemakaian di controller unggah.
- [ ] nwidart/laravel-modules & eloquent-sluggable → versi L12.

**Titik uji**: `composer install` sukses; `php artisan route:list` jalan; smoke test hijau.
**Rollback**: revert commit per langkah major.

### Fase 1b — Blocker Nue & SSO (KRITIS, kerjakan paralel Fase 1)
- [ ] Uji `novay/nue 2.26` + `nue-extensions/*` di Laravel target. Bila gagal:
      cari versi baru → jika tak ada, fork/patch lokal via `repositories` (path/vcs).
- [ ] Uji `novay/sso-client` + middleware `SSOAutoLogin` end-to-end. Fork/patch bila perlu.
- [ ] Bila L12 tak tercapai → **fallback Laravel 11**, konfirmasi ke user.

**Titik uji**: panel admin Nue login & operasi jalan; SSO login sukses.

---

## Fase 2 — Bersihkan SIKERJA + hapus penjurian Beimbai

- [ ] Rename prefix route `sikerja` → `jarsiplus`:
      `Modules/Formulir/Routes/web.php:14`, `Modules/Core/Routes/web.php:22`,
      `Modules/Pemohon/Routes/web.php:14`. (Nama route tetap `epanel.*`.)
- [ ] Branding: `Modules/Template/.../notification.blade.php:16` → `logo-jarsiplus.svg`;
      `Modules/Core/.../file/edit.blade.php:15` breadcrumb `SIKERJA` → `JARSIPLUS`.
- [ ] Hapus aset & orphan (grep verifikasi tak dirujuk dulu): `public_/`,
      `logo-sikerja-*.svg`, `assets/img/sikerja.svg`, `SiKerja *.png`.
- [ ] Hapus penjurian Beimbai: route `Modules/Formulir/Routes/web.php:44`,
      `Modules/Formulir/Http/Controllers/Beimbai/PenilaianController.php`,
      `Modules/Formulir/Entities/Beimbai/Penilaian.php` (stub). Base penilaian JANGAN disentuh.
- [ ] **Path storage `sikerja/`**: DEFAULT tidak diubah (menunjuk data produksi). Migrasi
      penuh opsional (move folder + `UPDATE REPLACE` kolom path + backup) — di luar jalur kritis.

**Titik uji**: `route:list` tanpa `beimbai-permohonan.penilaian`; grep `sikerja` di kode = 0
(kecuali path storage); admin & pemohon jalan.
**Rollback**: revert commit fase 2.

---

## Fase 3 — Rombak frontend publik + pemohon → Inertia + Vue 3

- [ ] Toolchain: buang `laravel-mix`; pasang `vite`, `laravel-vite-plugin`,
      `@vitejs/plugin-vue`, `vue@3`, `@inertiajs/vue3` + adapter Laravel Inertia.
- [ ] Buang PWA: hapus `silviolleite/laravelpwa`, `serviceworker.js`, `__manifest.json`,
      registrasi SW, config PWA.
- [ ] Setup Inertia: middleware `HandleInertiaRequests`, root `app.blade.php`,
      entry `resources/js/app.js`. Grup route e-panel TETAP Blade.
- [ ] Tetapkan strategi realtime pembahasan (Reverb/Echo vs socket.io) — SRS 6.4.
- [ ] Port halaman publik ke Vue: landing, informasi, statistik, faq, maintenance.
- [ ] Port area pemohon ke Vue: permohonan resource + detail/pembahasan/riwayat/finish/
      persetujuan/kirim, berkas, indikator, data, settings (account/profile/corporate).
- [ ] Ubah controller Template: `view()` → `Inertia::render()` dengan props setara.

**Titik uji**: `npm run build` sukses; tiap halaman publik+pemohon parity vs versi lama;
tidak ada serviceworker aktif.
**Rollback**: fitur di-branch terpisah; merge per halaman setelah parity terverifikasi.

---

## Fase 4 — QA & Rilis

- [ ] Jalankan seluruh smoke test Fase 0; bandingkan lama vs baru.
- [ ] Regression penuh panel admin Nue (visual & fungsi sama).
- [ ] Uji SSO pemohon & staf; feed juri; unggah/baca file lama (path `sikerja/`).
- [ ] Audit akhir: 0 `sikerja` di kode, 0 PWA, penjurian Beimbai hilang.
- [ ] `composer install` + `npm run build` + test suite hijau.
- [ ] Deploy ke staging → verifikasi → produksi.

---

## Urutan commit disarankan
1. `chore: git baseline + secret hygiene` (Fase 0)
2. `build: upgrade laravel 8→9 … →12` (per langkah, Fase 1)
3. `fix: nue & sso compat` (Fase 1b)
4. `refactor: bersihkan sisa SIKERJA` + `feat: hapus penjurian Beimbai` (Fase 2)
5. `build: mix→vite, hapus PWA` (Fase 3)
6. `feat: port halaman publik+pemohon ke Inertia/Vue` (Fase 3, per halaman)
7. `test: QA parity + rilis` (Fase 4)

## Estimasi risiko per fase
| Fase | Risiko | Catatan |
|---|---|---|
| 0 | Rendah | Prasyarat |
| 1 | Sedang | Breaking bertahap |
| 1b | **Tinggi** | Nue/SSO penentu; siapkan fork |
| 2 | Rendah | String & file mati |
| 3 | Sedang–Tinggi | Volume port besar; jaga parity |
| 4 | Sedang | Verifikasi menyeluruh |

## Keputusan tertunda (tetapkan saat eksekusi)
- Laravel 12 vs fallback 11 (tergantung Nue/SSO).
- Realtime: Reverb/Echo vs socket.io.
- Styling: Tailwind vs port CSS existing.
- Migrasi path storage `sikerja/`: ya/tidak.
