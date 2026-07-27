# Task Breakdown — Modernisasi JARSIPLUS 2026

**Rujukan**: PRD.md, SRS.md, plan.md
**Versi**: 1.0
**Tanggal**: 2026-07-27

Rincian tugas per fase. Format: `ID — Judul — Estimasi — Ketergantungan`.
Estimasi relatif (S=kecil, M=sedang, L=besar).

---

## Fase 0 — Persiapan

| ID | Tugas | Est | Depend |
|---|---|---|---|
| T0.1 | `git init` + commit baseline seluruh repo | S | — |
| T0.2 | Pindah `.env` & `database_dump.sql` keluar repo, `.gitignore`, rotasi secret | M | T0.1 |
| T0.3 | Setup PHP 8.3 + MySQL lokal, jalankan app baseline | M | T0.1 |
| T0.4 | Generate migration nyata dari `database_dump.sql` (skema tanpa data) | L | T0.3 |
| T0.5 | Tulis daftar smoke test manual alur kunci | S | T0.3 |

## Fase 1 — Upgrade Laravel + PHP

| ID | Tugas | Est | Depend |
|---|---|---|---|
| T1.1 | Upgrade 8→9: buang fruitcake/cors, ignition→spatie | M | T0.* |
| T1.2 | Upgrade 9→10: Sanctum/Collision/PHPUnit naik, cek deprecasi | M | T1.1 |
| T1.3 | Upgrade 10→11: PHP 8.2, opsi struktur `bootstrap/app.php` | M | T1.2 |
| T1.4 | Upgrade 11→12: seluruh paket L12, PHP 8.3 | M | T1.3 |
| T1.5 | Refactor helper `str_slug`/`str_random` → `Str::` | S | T1.1 |
| T1.6 | intervention/image v2→v3, sesuaikan controller unggah | M | T1.4 |
| T1.7 | nwidart/laravel-modules & eloquent-sluggable → L12 | S | T1.4 |

## Fase 1b — Blocker Nue & SSO (kritis)

| ID | Tugas | Est | Depend |
|---|---|---|---|
| T1b.1 | Uji novay/nue + nue-extensions di Laravel target | M | T1.4 |
| T1b.2 | Fork/patch Nue lokal bila tak kompatibel (visual sama) | L | T1b.1 |
| T1b.3 | Uji novay/sso-client + `SSOAutoLogin` end-to-end | M | T1.4 |
| T1b.4 | Fork/patch SSO client bila perlu | L | T1b.3 |
| T1b.5 | Keputusan L12 vs fallback L11 (konfirmasi user) | S | T1b.1,T1b.3 |

## Fase 2 — Bersihkan SIKERJA + hapus penjurian Beimbai

| ID | Tugas | Est | Depend |
|---|---|---|---|
| T2.1 | Rename prefix route `sikerja`→`jarsiplus` (3 file route) | S | T1.* |
| T2.2 | Branding: logo notification + breadcrumb edit.blade | S | T1.* |
| T2.3 | Grep verifikasi + hapus aset & folder orphan SIKERJA | S | T2.2 |
| T2.4 | Hapus route+controller+stub penjurian Beimbai | S | T1.* |
| T2.5 | (Opsional) migrasi path storage `sikerja/` + UPDATE DB | L | T2.1 |

## Fase 3 — Frontend Inertia + Vue 3

| ID | Tugas | Est | Depend |
|---|---|---|---|
| T3.1 | Ganti Mix→Vite, pasang vue3+inertia+plugin | M | T1.4 |
| T3.2 | Hapus PWA (laravelpwa, serviceworker, manifest, config) | S | T3.1 |
| T3.3 | Setup Inertia (middleware, root blade, entry js) | M | T3.1 |
| T3.4 | Tetapkan strategi realtime pembahasan (Reverb vs socket.io) | S | T3.3 |
| T3.5 | Port halaman publik → Vue (landing, info, statistik, faq, maintenance) | L | T3.3 |
| T3.6 | Port area pemohon → Vue (permohonan, berkas, indikator, pembahasan, settings) | L | T3.3 |
| T3.7 | Ubah controller Template `view()`→`Inertia::render()` | M | T3.5,T3.6 |

## Fase 4 — QA & Rilis

| ID | Tugas | Est | Depend |
|---|---|---|---|
| T4.1 | Jalankan smoke test, bandingkan lama vs baru | M | T3.* |
| T4.2 | Regression panel admin Nue (visual & fungsi) | M | T2.*,T1b.* |
| T4.3 | Uji SSO, feed juri, baca file lama path `sikerja/` | M | T4.1 |
| T4.4 | Audit akhir: 0 sikerja, 0 PWA, Beimbai penjurian hilang | S | T4.1 |
| T4.5 | `composer install`+`npm run build`+test hijau | S | T4.1 |
| T4.6 | Deploy staging → verifikasi → produksi | M | T4.* |

---

## Jalur kritis
T0.1 → T1.1..T1.4 → T1b.1/T1b.3 (blocker) → T2.* → T3.* → T4.*

Blocker penentu keseluruhan: **T1b.1–T1b.4 (Nue & SSO)**. Bila gagal L12 → fallback L11 (T1b.5).
