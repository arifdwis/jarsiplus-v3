# Redesign Frontend — JARSIPLUS 2026

**Spesifikasi Desain, Arsitektur Presentasi & Rencana Implementasi**
Frontend Publik & Portal Pemohon · Pure Laravel Blade (Buildless)

| | |
|---|---|
| **Versi** | 3.0 |
| **Tanggal** | 2026-07-27 |
| **Design system** | `design.md` — *Mahakam Civic Innovation* |
| **Token existing** | `public/css/jarsiplus-tokens.css` (prefix `--jp-*`) |
| **Rujukan** | PRD.md · SRS.md · plan.md |
| **Lingkup** | `Modules/Template` (publik + pemohon). **Epanel/Nue TIDAK disentuh.** |
| **Stack** | Laravel 12 · PHP 8.4 · Blade · CSS/JS statis — **tanpa Vite/Node/Vue** |

---

## Daftar Isi
1. Ringkasan Eksekutif
2. Prinsip & Batasan
3. Arsitektur Informasi (Sitemap)
4. Sistem Desain (Foundations)
5. Arsitektur CSS & Penamaan
6. Katalog Komponen
7. Kerangka Layout (Shell)
8. Beranda — Rancangan per Section (data nyata)
9. Halaman Publik Lain
10. Portal Pemohon (parity)
11. Pola Interaksi & Status (toast, loading, empty, error)
12. Aksesibilitas
13. Responsif
14. Performa & SEO
15. Yang Dihapus (dead code & mobile-kit)
16. Struktur Berkas & Aset
17. Rencana Implementasi (fase + Definition of Done)
18. Verifikasi & QA
19. Risiko
20. Keputusan Tertunda · Glosarium

---

## 1. Ringkasan Eksekutif

Frontend publik JARSIPLUS saat ini dibangun di atas **mobile-UI-kit** (`#appCapsule`, `custom.css`
150KB, jQuery 3.4 + Bootstrap 4.5 + ionicons + OwlCarousel via CDN) sehingga tampil sebagai aplikasi
mobile, bukan situs pemerintahan. Lapisan **Vue 3 + Inertia + Vite** yang sempat dipasang **tidak
pernah tersambung** — nol pemakaian `Inertia::render`; seluruh controller sudah mengembalikan Blade
(`return view('template::...')`).

Redesign ini merombak total tampilan depan menjadi **situs editorial ber-section** yang profesional,
elegan, dan proporsional, mengikuti design system **Mahakam Civic Innovation** (kanvas terang, teal
Mahakam, aksen amber), dijalankan **murni Blade + CSS/JS statis tanpa proses build**. Beranda diisi
**data nyata** (statistik permohonan, banner event dari tabel `slider`, informasi dari `laman`, FAQ)
agar hidup dan informatif. Seluruh fungsi & data pemohon dipertahankan (parity). Panel admin (Nue)
tidak disentuh sama sekali.

**Hasil yang diharapkan**: situs cepat (tanpa bundle JS berat), identitas visual orisinal (bukan
jiplakan), mudah dirawat (satu bahasa: Blade + token CSS), dan konsisten lintas halaman.

---

## 2. Prinsip & Batasan

### 2.1 Prinsip desain
1. **Editorial, resmi, hangat** — kanvas terang, lapang, hierarki kuat. Bukan dark-tech, bukan mobile-app.
2. **Identitas lokal Samakan (Mahakam)** — palet & motif sungai khas Samarinda; orisinal.
3. **Kejelasan > dekorasi** — tipografi & whitespace memimpin; efek berat (blur, gradient bertumpuk) dihindari.
4. **Proporsional** — ritme vertikal & grid konsisten (skala 4px), rasio tipografi major-third.
5. **Aksesibel** — WCAG 2.1 AA; keyboard-first; `prefers-reduced-motion`.
6. **Buildless & ringan** — CSS/JS statis; anggaran performa ketat (Bab 14).

### 2.2 Batasan keras
| # | Batasan |
|---|---|
| B1 | Tanpa Node/npm/Vite/Vue/Inertia. Tidak ada langkah build. |
| B2 | Pure Blade via `template::layouts.master`. |
| B3 | **Epanel/Nue off-limits** (lihat daftar Bab 16). |
| B4 | Buang total mobile-kit (`#appCapsule`, `custom.css/js`, jQuery/BS4/ionicons). |
| B5 | Layout web ber-section full-width, bukan kartu aplikasi mobile. |
| B6 | Beranda & section pendukung memakai data nyata. |
| B7 | Orisinal — adaptasi disiplin, bukan tata letak/aset referensi. |

---

## 3. Arsitektur Informasi (Sitemap)

```
Publik (tanpa login)
├─ /                  Beranda (hero, banner event, statistik, alur, informasi, FAQ, CTA)
├─ /informasi         Daftar & detail Laman (berita/pengumuman)
├─ /statistik         Dashboard publik (KPI + tren)
├─ /faq               Pertanyaan umum (accordion + cari)
├─ /maintenance       Halaman pemeliharaan
└─ /login (auth)      Masuk SSO pemohon

Portal Pemohon (auth SSO) — parity fungsi lama
├─ /permohonan                 Daftar permohonan (status)
├─ /permohonan/create          Form pengajuan (stepper multi-segmen)
├─ /permohonan/{uuid}/detail   Ringkasan + timeline
├─ /permohonan/{uuid}/berkas   Bukti dukung per indikator
├─ /permohonan/{uuid}/indikator, /pembahasan, /riwayat, /finish, /persetujuan, /kirim
├─ /settings/{account,profile,corporate}
└─ /beimbai/**                 (reskin; penjurian sudah dihapus)

Admin (Nue) — DI LUAR LINGKUP
└─ /jarsiplus/*  ·  /sikerja/*  ·  Nue auth   → tidak diubah
```
**Navigasi utama**: Beranda · Informasi · Statistik · FAQ. **CTA**: "Masuk Portal Pemohon".
Tautan diskret "E-Panel Admin" → `/jarsiplus/...` (admin, terpisah).

---

## 4. Sistem Desain (Foundations)

Selaras dengan token yang **sudah ada** di `jarsiplus-tokens.css` (prefix `--jp-*`). Redesign
**memperluas & merapikan**, bukan mengganti nama.

### 4.1 Warna & peran
| Token | Nilai | Peran | Kontras (teks) |
|---|---|---|---|
| `--jp-paper` | `#F7F5F0` | Kanvas utama | ink 900 = AAA |
| `--jp-surface` | `#FFFFFF` | Permukaan kartu | ink 900 = AAA |
| `--jp-surface-strong` | `#14202B` | Footer / band gelap | putih = AAA |
| `--jp-ink` | `#14202B` | Judul & teks utama | — |
| `--jp-ink-muted` | `#52616B` | Teks sekunder | AA di paper |
| `--jp-ink-subtle` | `#71808A` | Metadata | AA (≥16px) |
| `--jp-rule` | `#DED8CD` | Garis/border | — |
| `--jp-teal` | `#0E8F79` | CTA utama, link | putih = AA |
| `--jp-teal-strong` | `#075D50` | Hover CTA | putih = AAA |
| `--jp-teal-soft` | `#E7F4F0` | Latar lembut/aktif | — |
| `--jp-amber` | `#C8871B` | Aksen, highlight | putih = AA |
| `--jp-success/danger` (+ `-bg`) | — | Status | — |

**Aturan status permohonan** (kode DB nyata): `0 → Proses` (info), `1 → Disetujui` (success),
`2 → Selesai` (teal), `9 → Ditolak` (danger). Dipakai `x-badge`.

### 4.2 Tipografi
- **Heading**: Plus Jakarta Sans 600–800. **Body**: Inter 400–700, `line-height 1.6`.
- **Self-host** woff2 (buang `@import` Google Fonts di `jarsiplus-tokens.css` → `@font-face` lokal).
- Skala major-third:

| Token | Ukuran | Pemakaian |
|---|---|---|
| `--t-display` | 3.75rem | Hero (desktop) |
| `--t-4xl` | 3rem | Judul halaman |
| `--t-3xl` | 2.25rem | Judul section |
| `--t-2xl` | 1.875rem | Sub-judul |
| `--t-xl` | 1.5rem | Judul kartu |
| `--t-lg` | 1.25rem | Lead |
| `--t-md` | 1.125rem | Body besar |
| `--t-base` | 1rem | Body |
| `--t-sm` | .875rem | Caption |
| `--t-xs` | .75rem | Eyebrow/label |

Angka statistik: `font-variant-numeric: tabular-nums`, berat 800.

### 4.3 Spasi, grid, elevasi, motion
- **Grid 4px** (`--space-*` sudah ada). **Ritme section**: `--space-3xl`(64) mobile → 96px desktop.
- **Layout**: container `max-width 1200px`, gutter 24px, 12-col fluid (CSS grid).
- **Radius**: kartu 16, input 10, badge 8 (`--radius-*`).
- **Elevasi**: `--shadow-soft` (default), `--shadow-hover`. Tanpa glow warna.
- **Motion**: `--dur` 240ms, `--ease-out`. Animasi masuk halus (fade/translate 8px), hormati reduced-motion.

### 4.4 Ikonografi & motif
- **Ikon**: SVG sprite garis tunggal `img/icons/sprite.svg` (`<svg><use href="#nama"></svg>`), stroke seragam.
- **FlowMotif**: garis alur Sungai Mahakam (SVG orisinal) sebagai pembatas section & tekstur hero/footer.

---

## 5. Arsitektur CSS & Penamaan

- **Buildless**: dua file — `jarsiplus-tokens.css` (variabel, `@font-face`) + `jarsiplus.css` (base+layout+komponen).
  Selaras/menggantikan `jarsiplus-tokens.css`/`jarsiplus.css` yang ada (pertahankan nama `jarsiplus*`
  bila ingin minim ubah referensi `master.blade`).
- **Lapisan** (ITCSS ringkas): `1) tokens → 2) base/reset → 3) layout (l-*) → 4) komponen (jp-*) → 5) utilities (u-*)`.
- **Penamaan BEM prefiks `jp-`**: `.jp-card`, `.jp-card__title`, `.jp-card--featured`. Utilities pendek:
  `.u-mt-lg`, `.u-text-center`. **Tak ada hex hardcoded** — semua `var(--jp-*)`.
- Blade Components (`<x-...>`) membungkus markup; kelas CSS tetap `jp-*`.

---

## 6. Katalog Komponen

Lokasi: `Modules/Template/Resources/views/components/`. Tiap komponen: anatomi + varian + state.

| Komponen | Varian | State | Catatan |
|---|---|---|---|
| `x-btn` | primary, secondary, quiet, accent · sm/md/lg | hover, active, focus-visible, disabled, loading | radius 10; ikon opsional |
| `x-card` | default, featured, media | hover-lift | `--shadow-soft`→`--shadow-hover` |
| `x-stat-tile` | plain, trend | — | angka tabular, label, delta ±% |
| `x-badge` | status(0/1/2/9), neutral | — | teks + titik warna |
| `x-section` | light, soft(teal-soft), strong(dark) | — | eyebrow+judul+lead+slot; pengatur ritme |
| `x-field` | text, textarea, select, file | default, focus, error, disabled | label+helper+error; `aria-describedby` |
| `x-file-drop` | single, multi | drag-over, uploading | progres; validasi tipe/ukuran |
| `x-accordion(-item)` | — | open/closed | `button`+`aria-expanded`; keyboard |
| `x-stepper` | horizontal, vertical(mobile) | current/done/todo | tahap form permohonan |
| `x-timeline` | — | — | riwayat & pembahasan (ganti chat kit) |
| `x-carousel` | — | manual, pause-on-hover | banner event; tanpa autoplay |
| `x-empty` / `x-skeleton` | — | — | kondisi kosong/loading |
| `x-toast` | success, error, info | auto-dismiss | ganti dialog jQuery `notify()` |
| `x-icon` | — | — | wrapper sprite |

---

## 7. Kerangka Layout (Shell)

`master.blade.php` dirombak — buang `#appCapsule`, CDN kit, dialog jQuery. Struktur baru:

```blade
<!doctype html><html lang="id"><head>
  <meta viewport ...>  <title>@yield('title', config('app.name'))</title>
  <meta name="description" ...>  {{-- SEO Bab 14 --}}
  <link rel="icon" href="img/brand/favicon.svg">
  <link rel="stylesheet" href="css/jarsiplus-tokens.css?v=APP_VERSION">
  <link rel="stylesheet" href="css/jarsiplus.css?v=APP_VERSION">
  @stack('css')
</head><body class="jp-site">
  @include('template::layouts.partials.topbar')   {{-- instansi/kontak, tipis --}}
  @include('template::layouts.partials.header')    {{-- .jp-header sticky: logo, nav, CTA --}}
  <main id="main">@yield('content')</main>
  @include('template::layouts.partials.footer')    {{-- .jp-footer statement, surface-strong --}}
  <x-toast/>                                        {{-- render kondisional dari notify() --}}
  <script defer src="js/jarsiplus.js?v=APP_VERSION"></script>
  @stack('js')
</body></html>
```

**Header** (desktop): logo kiri · nav horizontal (Beranda/Informasi/Statistik/FAQ) · kanan CTA
"Masuk Portal Pemohon" + link "E-Panel Admin". Sticky, shadow muncul saat scroll. **Mobile**: tombol
menu → drawer (`role="dialog"`, focus-trap, Esc), **tanpa bottom-nav**.
**Footer**: pernyataan brand + kontak instansi + tautan penting + motif; **bukan** sitemap 7 kolom.

---

## 8. Beranda — Rancangan per Section (data nyata)

`TemplateController@index` diperkaya query (model sudah ada). Wireframe & sumber data tiap section:

**S1 · Hero**
```
┌───────────────────────────────────────────────┐
│ [eyebrow] PEMERINTAH KOTA SAMARINDA            │
│  Jaringan Inovasi Plus Daerah                  │   ~ FlowMotif sungai (SVG)
│  Ajukan & pantau inovasi daerah Anda.          │
│  [ Ajukan Inovasi ]  [ Pelajari Alur ]         │
└───────────────────────────────────────────────┘
```
Data: statis + `config('app.name')`.

**S2 · Banner Event / Pengumuman** — `x-carousel` manual, pause-on-hover.
Data: `Modules\Core\Entities\Slider::latest()->take(5)` → field `judul`, `label`, `file` (gambar),
`slug`. Kosong → sembunyikan section.

**S3 · Statistik Ringkas** — baris `x-stat-tile`.
Data (pola sama `StatistikController`): `Permohonan::count()` (Total), `where('status',1)` (Disetujui),
`where('status',0)` (Proses), `Pemohon::count()` (Inovator). Angka tabular + ikon.

**S4 · Alur Pengajuan** — 4 langkah bernomor + ikon sprite.
`Daftar/Login SSO → Isi indikator & unggah bukti → Pembahasan & validasi → Persetujuan`. Statis.

**S5 · Informasi Terbaru** — grid `x-card` (3–6).
Data: `Laman::where('status',1)->latest()->take(6)` → `label`, ringkasan `content` (strip+limit),
`slug` → link `/informasi/{slug}`.

**S6 · Inovasi Terbaru/Unggulan** *(opsional, konfirmasi)* — grid kartu.
Data: `Permohonan::where('status',1)->latest()->take(6)` (judul, kategori, pemohon).

**S7 · FAQ Ringkas** — `x-accordion` 4–5 + tautan `/faq`.
Data: tabel `faq` (`Faq::take(5)` / `DB::table('faq')`).

**S8 · CTA Penutup** — band `--jp-teal-soft`, ajakan masuk portal.

**S9 · Footer** — lihat Bab 7.

> Setiap section memakai `x-section` (eyebrow+judul+lead) untuk ritme & proporsi konsisten. Section
> tanpa data menampilkan `x-empty` atau disembunyikan — beranda tidak pernah tampak sepi.

---

## 9. Halaman Publik Lain

| Halaman | View | Rancangan | Data |
|---|---|---|---|
| Informasi | `template::informasi` | Daftar artikel + detail; kolom baca max 72ch, LH 1.6; sidebar daftar isi; breadcrumb | `Laman` (status 1) |
| Statistik | `template::statistik.index` | KPI `x-stat-tile` + **tren CSS/SVG murni** (bar 7-hari & 12-bulan) + tabel 10 pemohon terbaru | `StatistikController` (sudah menyediakan `permohonanPerHari/Bulan`, `pemohon`, count status) |
| FAQ | `template::faq.index` | `x-accordion` + pencarian client-side (vanilla) + chip kategori | tabel `faq` |
| Maintenance | `template::maintenance` | Layar tenang ber-motif, pesan + estimasi | statis |
| Login | `resources/views/auth/login.blade.php` | Reskin `x-field`; alur SSO tetap | — |

Grafik statistik **tanpa library**: bar chart = elemen `<div>`/`<rect>` SVG tinggi proporsional dari
array `counts`; aksesibel via `<title>`/tabel pendamping.

---

## 10. Portal Pemohon (parity, buang appCapsule)

Reskin ke Mahakam; logika/route/props tetap. Semua `@extends('template::layouts.master')` baru.

| Alur | View | Rancangan |
|---|---|---|
| Daftar | `permohonan/index` | Tabel/kartu + `x-badge` status (0/1/2/9), filter status, `x-empty` |
| Buat | `permohonan/create` + `form/segment_{1,2,3}` | `x-stepper` 3 segmen, `x-field`/`x-file-drop`, ringkasan pra-kirim |
| Detail | `permohonan/detail` | Header status + `x-timeline` riwayat + panel berkas & indikator |
| Berkas | `permohonan/berkas/**` | `x-file-drop` per indikator, daftar bukti |
| Indikator | `permohonan/indikator/**`, `indikator/data/**` | Form penilaian mandiri + unggah |
| Pembahasan | `permohonan/pembahasan/**` | `x-timeline` diskusi (ganti chat kit); realtime REST/Reverb-ready |
| Pengaturan | `settings/{account,profile,corporate}/form` | `x-field` |
| Roles | `roles/{pemohon,tksd,null}` | Reskin state |
| Beimbai | `beimbai/permohonan/**` | Reskin sama (penjurian sudah dihapus) |

---

## 11. Pola Interaksi & Status

- **Toast** (`x-toast`): ganti dialog modal jQuery. Render dari `notify()` server → elemen statis
  `role="status"`, auto-dismiss 4s, dismissible, stack kanan-atas. Tanpa BS4/jQuery.
- **Loading**: `x-skeleton` untuk kartu/daftar (bila ada fetch); form submit → tombol state `loading`.
- **Empty**: `x-empty` (ikon + pesan + aksi). **Error**: banner inline `--jp-danger-bg`.
- **Validasi form**: pesan Laravel → `x-field` error + `aria-invalid`, fokus ke field pertama gagal.

`jarsiplus.js` (vanilla, ±1 file) menangani: drawer, accordion, carousel manual, toast dismiss,
counter angka statistik, pencarian FAQ, sticky header. Tanpa dependensi.

---

## 12. Aksesibilitas (WCAG 2.1 AA)
- Kontras teks ≥ 4.5:1 (≥3:1 teks besar) — pasangan warna Bab 4.1 lulus.
- `:focus-visible` ring `--jp-teal` 2px + offset; tak ada `outline:none` tanpa pengganti.
- Landmark: `header/nav/main/footer`; `main#main` + skip-link "Lewati ke konten".
- Drawer/accordion/carousel: pola ARIA benar, operable keyboard, `aria-expanded/controls`.
- Gambar `alt` bermakna; ikon dekoratif `aria-hidden`. Target sentuh ≥44px.
- Hormati `prefers-reduced-motion` (matikan animasi non-esensial). Bahasa `lang="id"`.

## 13. Responsif
| Breakpoint | Lebar | Perilaku |
|---|---|---|
| Mobile | ≤640px | 1 kolom; nav→drawer; stepper vertikal; stat 2×2 |
| Tablet | 641–1024 | 2 kolom; container padding 24 |
| Desktop | ≥1025 | 12-col; container 1200; ritme 96px |

Fluida, `max-width:100%` media, tabel lebar `overflow-x:auto`; **body tanpa horizontal scroll**.

## 14. Performa & SEO
- **Anggaran**: CSS ≤ 60KB, JS ≤ 20KB (jarsiplus.js), **0 dependensi CDN**, font self-host `font-display:swap`.
  Gambar `loading="lazy"` + dimensi eksplisit; hero image `preload`.
- Tanpa bundle Vue (hemat ±252KB JS lama). Cache-bust `?v=config('app.version')`.
- **SEO/meta**: `<title>` per halaman, meta description dinamis, Open Graph (`og:title/description/image`),
  canonical, `robots`, data terstruktur `GovernmentOrganization` (JSON-LD) di beranda. `sitemap.xml`.

## 15. Yang Dihapus

**Scaffold Vue/Inertia/Vite (dead code):** `package*.json`, `vite.config.js`, `node_modules/`,
`public/build/`, `resources/js/**`, `resources/css/{app,tokens}.css`, `resources/views/app.blade.php`,
`app/Http/Middleware/HandleInertiaRequests.php` (+ `app/Http/Kernel.php:44`), composer
`inertiajs/inertia-laravel` (→ `composer update`, `php artisan optimize:clear`), stub Mix
`Modules/{Template,Pemohon}/webpack.mix.js`+`package.json`+`Resources/assets/**`.

**Mobile-kit lama:** di `master.blade.php` — `#appCapsule`, `custom.css`, `custom.js`, CDN jQuery/BS4/
ionicons/lity/OwlCarousel/mobile-detect/circle-progress, dialog `$('#dialog-box').modal`, favicon
`logo-mobile/...`. Partial orphan `layouts/partials/{bottom,homescreen,notification,sidebar}.blade.php`.
Aset `public_html/css/custom.css`, `public_html/js/{custom,chat,map,permohonan}.js`, `images/logo-mobile/**`.

## 16. Struktur Berkas & Aset

**Web root**: tetapkan `public_html/` tunggal; sinkron `public/` (symlink). Aset baru:
```
public_html/
  css/  jarsiplus-tokens.css  jarsiplus.css
  js/   jarsiplus.js
  fonts/  PlusJakartaSans-*.woff2  Inter-*.woff2
  img/  brand/ (logo,favicon)  motif/ (flow.svg)  icons/sprite.svg
```
**Diubah:** `Modules/Template/Resources/views/layouts/{master,partials/*}.blade.php`,
`components/**` (baru), `{index,informasi,statistik/index,faq/index,maintenance}.blade.php`,
`{permohonan,settings,roles,beimbai}/**`, `Http/Controllers/{TemplateController,StatistikController}.php`,
`resources/views/auth/login.blade.php`.

**JANGAN sentuh (Epanel/Nue):** `resources/views/layouts/app.blade.php` & `layouts/*` admin,
`resources/views/dashboard.blade.php`, `packages/nue*`, `Modules/{Formulir,Pemohon(admin),Kategori,Wilayah,Core,Faq}`
sisi admin, `app/Http/Controllers/HomeController.php`, route `epanel.*` / Nue.

## 17. Rencana Implementasi (fase + Definition of Done)

| Fase | Isi | DoD |
|---|---|---|
| **R0 Cabut build** | Hapus scaffold Vue/Inertia (Bab 15), buang composer inertia, `optimize:clear` | App jalan, semua route publik/pemohon OK, tak ada `@vite`/`@inertia` |
| **R1 Fondasi** | Tokens+`@font-face` self-host, `jarsiplus.css` base, `jarsiplus.js`, sprite, FlowMotif, satu web root | Halaman apa pun render dgn token; 0 CDN; Lighthouse a11y ≥95 pada shell |
| **R2 Shell & komponen** | `master` baru, topbar/header/footer, `x-*` (Bab 6) | Header sticky + drawer aksesibel; toast gantikan modal; komponen terpakai |
| **R3 Beranda** | Perkaya `TemplateController@index`, 9 section (Bab 8) | Beranda berisi data nyata (slider/statistik/laman/faq); responsif; tanpa section sepi |
| **R4 Publik lain** | Informasi, Statistik (grafik SVG), FAQ, Maintenance, Login | Parity data; grafik akurat dari `StatistikController` |
| **R5 Pemohon** | Reskin `permohonan/**`, `settings/**`, `roles/**`, `beimbai/**` | Alur end-to-end parity; tanpa kelas kit |
| **R6 QA & bersih** | Hapus partial/aset lama; audit; uji | Bab 18 semua hijau |

Prinsip: satu section/halaman = satu commit; parity diverifikasi sebelum lanjut.

## 18. Verifikasi & QA
- [ ] Tanpa `node_modules`/`vite`/`vue`/inertia; cukup `composer install`; tidak ada `npm`.
- [ ] Beranda ber-section berisi data nyata (banner `slider`, statistik, `laman`, FAQ) — tidak sepi.
- [ ] Tak ada `#appCapsule`, `custom.css/js`, jQuery/BS4/ionicons, atau aset CDN eksternal.
- [ ] Alur pemohon parity (ajukan → unggah → pembahasan → kirim → riwayat).
- [ ] Epanel Nue tak berubah — `/jarsiplus/*` visual & fungsi sama.
- [ ] Statistik cocok dengan angka `StatistikController` (status 0/1/2/9, tren 7h/12bln).
- [ ] Audit desain: kanvas terang, tanpa gradient-clip/glassmorphism; kontras AA; keyboard OK.
- [ ] Responsif 360–1440px tanpa horizontal scroll; Lighthouse Perf ≥90, A11y ≥95.

## 19. Risiko
| Risiko | Dampak | Mitigasi |
|---|---|---|
| View pemohon banyak pakai kelas kit | Reskin makan waktu | Kerjakan per alur, komponen `x-*` reusable |
| `notify()` bergantung modal BS4 | Flash message rusak | `x-toast` statis membaca `notify()` |
| Split `public/` vs `public_html/` | Aset 404 | Satukan web root di R1 |
| Grafik tanpa lib | Effort tren chart | SVG sederhana dari array `counts` |
| Font self-host lisensi | Legal | Pakai font open-source (Plus Jakarta Sans & Inter, OFL) |

## 20. Keputusan Final · Glosarium

**Dikunci (mengikuti rekomendasi):**
| Keputusan | Pilihan final |
|---|---|
| Section S6 Inovasi Unggulan | **Dipakai** (data `Permohonan` status 1) |
| Grafik statistik | **SVG/CSS murni** (buildless, dari array `counts`) |
| Interaktivitas | **Vanilla JS** satu file `jarsiplus.js` (tanpa Alpine/npm) |
| Banner event | **Tabel `slider`** yang ada (tanpa entitas baru) |
| Nama file aset | **Pertahankan** `jarsiplus-tokens.css` / `jarsiplus.css` / `jarsiplus.js` |

**Glosarium:** *Epanel* = panel admin Nue · *Laman* = konten halaman/berita (`Modules\Core`) ·
*Slider* = banner (`Modules\Core`) · *Permohonan* status: 0 Proses·1 Disetujui·2 Selesai·9 Ditolak ·
*FlowMotif* = motif garis sungai Mahakam · *Buildless* = tanpa proses kompilasi aset.
