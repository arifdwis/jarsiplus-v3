# Redesign Blade — JARSIPLUS 2026

**Dokumen**: Spesifikasi desain, arsitektur presentasi, dan langkah implementasi
**Versi**: 3.0
**Tanggal**: 2026-07-27
**Rujukan**: `PRD.md`, `SRS.md`, `plan.md`, `checklist.md`, dan `design.md`
**Cakupan**: semua frontend publik dan portal pemohon di `Modules/Template/resources/views`
**Platform**: Laravel Blade + CSS + JavaScript progresif. **Tidak menggunakan Vue.js atau Inertia.**

> Hallmark · pre-emit critique: Philosophy 5 · Hierarchy 5 · Execution 5 · Specificity 5 · Restraint 5 · Variety 4

---

## 1. Keputusan arsitektur dan batas keras

Redesign dilakukan di atas aplikasi Blade yang sudah ada. Semua controller tetap mengembalikan `view()`, form tetap menggunakan Laravel Collective/HTML yang ada, pagination tetap server-rendered, dan AJAX pembahasan tetap memakai endpoint serta pola jQuery yang sudah berjalan. Tidak ada migrasi ke Vue, Inertia, Vite, SPA, atau perubahan kontrak data.

| Area | Keputusan |
| --- | --- |
| Publik | Redesign penuh: beranda, informasi, statistik, FAQ, maintenance |
| Pemohon | Redesign penuh: daftar permohonan, buat, detail, indikator, berkas, pembahasan, riwayat, finish, dan settings |
| E-panel/Nue | Tidak disentuh: tidak ada edit markup, CSS, route, controller, atau asetnya |
| Backend | Tidak disentuh: route, middleware, SSO, controller, model, query, validasi, payload, dan storage tetap parity |
| JavaScript | Vanilla JS/jQuery yang sudah ada; interaksi baru harus progressive enhancement |

Dokumen ini menggantikan arahan frontend Vue/Inertia pada `docs/redesign.md` versi sebelumnya. Jika `PRD.md`, `SRS.md`, atau `plan.md` masih menyebut port frontend ke Vue/Inertia, catat sebagai keputusan yang dibatalkan sebelum implementasi agar dokumentasi proyek konsisten.

---

## 2. Referensi, orisinalitas, dan arah elegan

`design.md` dipakai sebagai referensi prinsip: kepemimpinan visual yang tegas, permukaan yang disiplin, dan CTA yang jelas. Implementasi JARSIPLUS tidak boleh menyalin elemen, aset, atau susunan Intel. Hasil akhirnya adalah sistem desain **Mahakam Civic Atelier**: layanan pemerintahan yang berwibawa, terang, tenang, dan terasa dibuat untuk perjalanan inovasi daerah.

| Prinsip yang dipelajari | Terjemahan orisinal JARSIPLUS |
| --- | --- |
| Hierarki konten yang kuat | Hero berbentuk briefing layanan, bukan hero promosi produk atau carousel |
| Kontras terang-gelap yang terkendali | Warm paper dan ink navy; bidang gelap hanya pada penekanan strategis |
| CTA jelas dan ringkas | Aksi `Ajukan Inovasi` dan `Pelajari Alur` dengan bahasa layanan publik |
| Disiplin ruang dan tipografi | Plus Jakarta Sans + Inter, ritme 4 px, garis Mahakam sebagai pembatas |

### Larangan anti-plagiarisme

- Jangan memakai logo, font, warna cyan/blue khas, copy, gambar, card news, footer, mega-menu, atau struktur carousel Intel.
- Jangan membuat ulang komposisi halaman Intel dalam warna berbeda.
- Jangan menggunakan gradient teks, glow neon, glassmorphism, mock browser/device, atau animasi autoplay.
- Jangan membuat metrik, testimoni, penghargaan, atau foto Samarinda yang tidak tersedia secara resmi.
- Jangan menggunakan foto stok sebagai bukti visual layanan pemerintah. Sebelum aset resmi tersedia, gunakan motif SVG/CSS orisinal yang abstrak.

---

## 3. Sistem desain: Mahakam Civic Atelier

**Genre**: modern-minimal civic editorial.
**Nada**: profesional, elegan, hening, kredibel, dan hangat.
**Metafora**: aliran Sungai Mahakam—garis rute sebagai perjalanan usulan, simpul sebagai bukti dan keputusan, ruang lega sebagai transparansi proses.

Motif Mahakam dibuat sendiri sebagai SVG garis tipis dan titik node; sifatnya dekoratif (`aria-hidden="true"`) dan hanya muncul pada hero publik, pembatas section, footer, serta maintenance. Area kerja pemohon berfokus pada informasi dan tindakan, tanpa dekorasi hero.

### Keluarga layout

| Keluarga | Struktur | Halaman |
| --- | --- | --- |
| Civic briefing | Pesan utama → aksi → angka aktual → alur → tindakan lanjutan | Beranda |
| Long document | Judul → konteks/navigasi → isi terbaca → CTA | Informasi, FAQ |
| Public ledger | Ringkasan data → status → definisi data | Statistik |
| Applicant workbench | Breadcrumb → status/konteks → aksi → data atau form | Seluruh pemohon |

---

## 4. Token visual dan aturan CSS

Satu file token Blade-only dibuat di `Modules/Template/Resources/assets/css/tokens.css` atau, bila aset template tetap di `public`, di `public/css/jarsiplus-tokens.css`. `layouts/master.blade.php` memuatnya setelah stylesheet legacy. Semua CSS redesign memakai token, bukan hex/font literal yang tersebar di view.

| Peran | Token | Nilai | Penggunaan |
| --- | --- | --- | --- |
| Kanvas | `--jp-paper` | `#F7F5F0` | Latar terang utama |
| Permukaan | `--jp-surface` | `#FFFFFF` | Panel, kartu, menu |
| Ink | `--jp-ink` | `#14202B` | Heading dan teks penting |
| Ink sekunder | `--jp-ink-muted` | `#52616B` | Body dan metadata |
| Garis | `--jp-rule` | `#DED8CD` | Border dan divider |
| Brand | `--jp-teal` | `#0E8F79` | CTA utama, link, focus |
| Brand gelap | `--jp-teal-strong` | `#075D50` | Hover/active |
| Brand lembut | `--jp-teal-soft` | `#E7F4F0` | Latar informatif |
| Aksen | `--jp-amber` | `#C8871B` | Highlight terbatas dan peringatan |
| Permukaan tegas | `--jp-ink-surface` | `#14202B` | Footer atau section penutup |

- Font display/UI: Plus Jakarta Sans; font body: Inter. Keduanya dipasang sebagai satu import/font-source terpusat dalam layout, bukan per halaman.
- Spasi menggunakan token 4 px (`--space-3xs` sampai `--space-4xl`); section 56 px mobile dan 96 px desktop.
- Radius: kartu 16 px; input dan tombol 10 px; chip/badge 8 px. Radius pill hanya untuk status kecil.
- Shadow netral dan ringan; hover meningkatkan elevasi, bukan kontras warna secara berlebihan.
- `html, body { overflow-x: clip; }`; judul panjang wajib `overflow-wrap: anywhere`.
- Durasi 180/240/320 ms dengan easing bernama. `prefers-reduced-motion` menghapus gerak spasial.

---

## 5. Struktur Blade dan komponen partial

### Layout publik/pemohon

`template::layouts.master` menjadi shell untuk frontend Blade, tetapi markup layout diperbarui tanpa mengganti route atau kontrol server:

- Header: wordmark JARSIPLUS, Beranda, Informasi, Statistik, FAQ, CTA Portal Pemohon, dan tautan E-Panel Admin yang jelas sebagai area terpisah.
- Mobile: tombol menu semantik dengan `aria-expanded`, `aria-controls`, Escape untuk menutup, dan fokus terlihat.
- Main: container responsif, breadcrumb opsional, flash notification Laravel yang tidak memblokir navigasi.
- Footer: pernyataan ringkas Pemerintah Kota Samarinda serta link layanan; bukan sitemap besar atau footer ala korporasi teknologi.

### Partial reusable

| Partial/komponen Blade | Tanggung jawab |
| --- | --- |
| `components/button.blade.php` | Varian primary, secondary, quiet, destructive; ukuran sm/md; disabled/loading |
| `components/card.blade.php` | Surface default, quiet, interactive; tanpa shadow berlebihan |
| `components/status-badge.blade.php` | Status berbasis teks+warna; dapat dipakai seluruh permohonan |
| `components/empty-state.blade.php` | Pesan kosong, tindakan kontekstual, tanpa ilustrasi generik |
| `components/form-field.blade.php` | Label, bantuan, error, required marker, dan ID aksesibel |
| `components/flow-motif.blade.php` | SVG motif Mahakam dekoratif |
| `components/accordion-item.blade.php` | Tombol FAQ/informasi dengan atribut ARIA dan fallback konten terbuka |
| `components/page-heading.blade.php` | Eyebrow opsional, heading, deskripsi, dan slot aksi |

Partial bersifat tambahan dan dipanggil dengan `@include`/`@component`; view lama dapat dimigrasikan satu per satu. Tidak ada penghapusan massal view atau perombakan controller.

### State interaksi

Setiap kontrol memiliki default, hover, `:focus-visible`, active, disabled, loading, error, dan success bila berlaku. JavaScript hanya meningkatkan pengalaman:

- Menu mobile dan accordion tetap menampilkan konten yang dapat dijangkau tanpa JavaScript.
- Error validasi server Laravel tetap menjadi sumber kebenaran; JS tidak menduplikasi validasi bisnis.
- Tombol submit menampilkan status proses dan mencegah klik ganda, tetapi form tetap dapat disubmit tanpa JavaScript.

---

## 6. Spesifikasi per halaman

### Beranda — `template::index`

1. Hero civic briefing: wordmark/identitas, judul layanan, deskripsi singkat, CTA `Ajukan Inovasi Daerah`, CTA sekunder `Pelajari Alur`, dan `flow-motif` orisinal.
2. Jika tidak login, fokus pada orientasi layanan. Jika login, gunakan sapaan singkat dan tindakan sesuai role tanpa mengubah aturan role yang ada.
3. Ringkasan proses menampilkan tiga tahap: daftarkan, lengkapi bukti, verifikasi dan pemetaan—dengan satu alur garis, bukan tiga kartu SaaS identik.
4. Statistik hanya ditampilkan bila controller menyediakan data aktual; bila tidak, beranda tidak menciptakan angka.

### Informasi — `template::informasi`

- Ubah accordion legacy menjadi dokumen layanan yang elegan: heading, ringkasan tujuan, daftar isi ringkas, dan panel informasi yang dapat dibuka.
- Isi `Laman` tetap berasal dari entity yang sama dan ditampilkan dengan tipografi long-form, heading semantik, tabel responsif, serta sanitasi output yang telah ada.
- Pada layar kecil, navigasi konteks berada di atas isi; tidak ada sidebar sempit.

### Statistik — `template::statistik.index`

- Header menerangkan bahwa angka berasal dari rekam usulan sistem.
- Kartu statistik menggunakan data controller yang sudah tersedia: proses, setuju, tolak, selesai, permohonan, dan pemohon.
- Grafik per hari/per bulan yang sudah disediakan controller boleh dirapikan sebagai SVG/Chart.js ringan; tidak menambah endpoint maupun mengarang data.
- Sertakan legenda status agar warna tidak menjadi satu-satunya pembeda.

### FAQ — `template::faq.index`

- Intro singkat, accordion satu kolom, serta marker fokus yang jelas.
- Satu item terbuka sebagai default, pengguna dapat membuka atau menutup item lain. Pagination tetap memakai data server yang sekarang.
- Pencarian dan kategori hanya ditambahkan setelah model/controller memberi data yang diperlukan.

### Maintenance — `template::maintenance`

- Pesan layanan yang singkat, aksi kembali ke beranda, dan motif Mahakam minimal.
- Tidak menyebut estimasi pemulihan atau penyebab yang tidak diberikan operator.

### Pemohon — `template::permohonan.*`

| View | Arah visual | Perilaku yang wajib tetap |
| --- | --- | --- |
| `index` | Workbench dengan heading, legenda status sebagai panel ringkas, kartu permohonan berisi kode/status/judul/aksi | Logika biodata, periode pendaftaran, pengecualian user, modal penutupan, dan route tetap |
| `create` + `form/*` | Breadcrumb, step header yang tenang, field terkelompok, sticky action hanya desktop | `Form::open`, field names, upload, select2, validasi dan route store tetap |
| `show`/`detail` | Header usulan dan status, ringkasan metadata, navigasi konteks ke indikator/berkas/pembahasan/riwayat | Data `$data`, komentar juri, dan semua action lama tetap |
| `indikator/*`, `berkas/*`, `data/*` | Daftar kerja dengan status bukti, area upload jelas, empty/error state | Payload upload, route, dan validasi file tetap |
| `pembahasan/*` | Percakapan berjarak baik dengan identitas/waktu jelas; field balasan selalu terlihat | AJAX chat dan partial render controller tetap |
| `riwayat`, `finish`, `penjadwalan` | Timeline dan summary status yang terbaca | Query/controller/action lama tetap |
| `settings/*` | Form akun/profil/korporasi dengan label dan pesan error konsisten | Resource route serta update controller tetap |

---

## 7. Langkah implementasi

1. **Sinkronkan keputusan dokumen**
   - Tetapkan Blade sebagai frontend target dan perbarui referensi Vue/Inertia pada `PRD.md`, `SRS.md`, `plan.md`, serta `checklist.md` agar tidak kontradiktif.
   - Perbarui `design.md` agar menjelaskan Mahakam Civic Atelier dan menghapus token/font/rujukan Intel yang akan dipakai implementasi.

2. **Audit batas e-panel dan baseline**
   - Catat screenshot/state e-panel sebelum mulai; exclude `resources/views/layouts/*`, `Modules/*` selain `Modules/Template/resources/views`, dan aset Nue dari perubahan.
   - Jalankan smoke test publik dan pemohon sebagai baseline sebelum mengubah presentasi.

3. **Buat fondasi CSS Blade**
   - Tambahkan token, typography, grid, responsive rules, focus ring, reduced motion, dan pola komponen ke stylesheet publik baru.
   - Muat stylesheet/font satu kali dari `template::layouts.master`; pertahankan stylesheet legacy sampai setiap view selesai dimigrasikan.
   - Hindari CDN baru bila aset dapat dilayani lokal; tidak perlu memasang framework frontend baru.

4. **Refactor shell dan partial**
   - Redesign `layouts/master.blade.php`, header, footer, bottom navigation, dan notifikasi hanya untuk area template publik/pemohon.
   - Tambahkan partial komponen; pindahkan markup berulang secara inkremental tanpa mengubah variabel Blade yang dipakai view.

5. **Migrasikan halaman publik**
   - Urutan: Beranda → Informasi → Statistik → FAQ → Maintenance.
   - Satu halaman per commit; lakukan visual QA dan cek route/HTML sebelum melanjutkan.

6. **Migrasikan workbench pemohon**
   - Urutan: Index → Create/form segments → Show/detail → indikator/berkas → pembahasan → riwayat/finish/penjadwalan → settings.
   - Pertahankan semua `name`, `id`, route helper, CSRF, selector JavaScript, data attributes, dan partial yang dipakai controller/AJAX.

7. **Hapus legacy visual secara aman**
   - Setelah semua view memakai sistem baru, hapus hanya CSS/JS legacy yang sudah dibuktikan tidak direferensikan oleh publik atau pemohon.
   - Setiap penghapusan file/asset harus dibahas dan disetujui terpisah; e-panel dilarang menjadi target cleanup.

8. **QA, aksesibilitas, dan rilis**
   - Uji route, validasi server, upload, pagination, modal penutupan, AJAX chat, SSO, dan flash notification.
   - Uji 320, 375, 414, 768, dan desktop; keyboard-only; zoom 200%; reduced motion; serta kontras WCAG AA.
   - Bandingkan e-panel dengan baseline: tampilan dan fungsi harus identik.

---

## 8. Kriteria penerimaan

- [ ] Tidak ada Vue, Inertia, SPA, atau toolchain frontend baru yang ditambahkan untuk redesign ini.
- [ ] Semua route publik dan pemohon tetap `view()` Blade serta seluruh form/action mempertahankan kontrak backend.
- [ ] E-panel/Nue tidak berubah pada diff, screenshot, dan smoke test.
- [ ] Beranda tidak memiliki carousel/autoplay, angka fiktif, atau elemen yang meniru Intel.
- [ ] CSS baru memakai token dan tidak menyebarkan warna/font literal baru ke berbagai view.
- [ ] Navigasi, accordion, modal, form, upload, dan chat tetap dapat dioperasikan keyboard serta tetap memiliki fallback tanpa JavaScript.
- [ ] Tidak ada horizontal scroll pada 320/375/414/768 px; CTA, breadcrumb, dan tautan navigasi tidak pecah dua baris.
- [ ] `php artisan route:list`, test suite, dan smoke test publik/pemohon/SSO tetap hijau.
- [ ] Kontras teks dan focus indicator memenuhi WCAG AA; target kontrol utama minimal 44 × 44 px bila ruang memungkinkan.

---

## 9. Urutan commit yang disarankan

1. `docs: define Blade-first Mahakam redesign`
2. `style: add public Blade design tokens and foundations`
3. `refactor: rebuild public Blade shell and partials`
4. `feat: redesign public Blade pages`
5. `feat: redesign applicant Blade workbench`
6. `test: verify Blade frontend parity and accessibility`
