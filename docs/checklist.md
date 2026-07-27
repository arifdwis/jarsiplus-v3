# Checklist Eksekusi — Modernisasi JARSIPLUS 2026

**Rujukan**: task.md, plan.md
**Versi**: 1.0

Centang saat selesai. Jangan lanjut fase berikut sebelum blok "Titik uji" fase terkait hijau.

---

## Fase 0 — Persiapan
- [x] T0.1 `git init` + commit baseline
- [x] T0.2 Secret keluar repo (`.env`, `database_dump.sql` di-`.gitignore`), rotasi APP_KEY/DB/SSO
- [ ] T0.3 PHP 8.3 + MySQL lokal, app baseline jalan
- [ ] T0.4 Migration nyata dari `database_dump.sql`
- [ ] T0.5 Daftar smoke test manual ditulis
- **Titik uji**: [ ] app baseline jalan, smoke test terdokumentasi

## Fase 1 — Upgrade Laravel + PHP
- [x] T1.1 8→9 (buang cors, ignition→spatie)
- [x] T1.2 9→10 (Sanctum/Collision/PHPUnit)
- [x] T1.3 10→11 (PHP 8.2)
- [x] T1.4 11→12 (PHP 8.3/8.4)
- [x] T1.5 Refactor `str_slug`/`str_random` → `Str::`
- [x] T1.6 intervention/image v2→v3
- [x] T1.7 laravel-modules & eloquent-sluggable → L12
- **Titik uji**: [x] `composer install` sukses, [x] `route:list` jalan, [ ] smoke test hijau

## Fase 1b — Blocker Nue & SSO
- [x] T1b.1 Uji Nue + nue-extensions di Laravel target
- [x] T1b.2 Fork/patch Nue (jika perlu, visual sama)
- [x] T1b.3 Uji SSO client + `SSOAutoLogin`
- [x] T1b.4 Fork/patch SSO client (jika perlu)
- [x] T1b.5 Keputusan L12 vs fallback L11 (konfirmasi user - Sukses di L12.64)
- **Titik uji**: [x] admin Nue login & operasi jalan, [x] SSO login sukses

## Fase 2 — Bersihkan SIKERJA + hapus penjurian Beimbai
- [x] T2.1 Prefix route `sikerja`→`jarsiplus` (Formulir/Core/Pemohon)
- [x] T2.2 Branding logo + breadcrumb
- [x] T2.3 Hapus aset & `public_/` (grep verifikasi dulu)
- [x] T2.4 Hapus penjurian Beimbai (route:44 + controller + stub)
- [ ] T2.5 (Opsional) migrasi path storage `sikerja/`
- **Titik uji**: [x] `route:list` tanpa `beimbai-permohonan.penilaian`, [x] grep `sikerja` kode = 0 (kecuali storage), [x] admin & pemohon jalan

## Fase 3 — Frontend Inertia + Vue 3
- [ ] T3.1 Mix→Vite + vue3/inertia terpasang
- [ ] T3.2 Hapus PWA (laravelpwa, serviceworker, manifest)
- [ ] T3.3 Setup Inertia (middleware, root blade, entry js)
- [ ] T3.4 Strategi realtime ditetapkan
- [ ] T3.5 Port halaman publik → Vue
- [ ] T3.6 Port area pemohon → Vue
- [ ] T3.7 Controller Template → `Inertia::render()`
- **Titik uji**: [ ] `npm run build` sukses, [ ] tiap halaman parity, [ ] tidak ada serviceworker aktif

## Fase 4 — QA & Rilis
- [ ] T4.1 Smoke test lama vs baru
- [ ] T4.2 Regression admin Nue (visual & fungsi sama)
- [ ] T4.3 Uji SSO, feed juri, baca file lama path `sikerja/`
- [ ] T4.4 Audit: 0 sikerja, 0 PWA, Beimbai penjurian hilang
- [ ] T4.5 `composer install` + `npm run build` + test hijau
- [ ] T4.6 Deploy staging → verifikasi → produksi

---

## Gerbang rilis (semua wajib hijau)
- [ ] App jalan PHP 8.3 + Laravel target tanpa error
- [ ] SSO login pemohon & staf sukses
- [ ] Alur pemohon & publik parity di Vue
- [ ] Panel admin berfungsi & tampil sama
- [ ] Tidak ada PWA, tidak ada jejak SIKERJA, penjurian Beimbai hilang
- [ ] File unggahan lama (path `sikerja/`) tetap terbaca
