# Redesign Frontend — JARSIPLUS 2026

**Dokumen**: Spesifikasi desain dan langkah implementasi
**Versi**: 2.0
**Tanggal**: 2026-07-27
**Rujukan**: `PRD.md`, `SRS.md`, `plan.md`, `checklist.md`
**Cakupan**: frontend publik dan portal pemohon berbasis Inertia + Vue 3.
**Batas keras**: e-panel admin/Nue (Blade), route admin, API, SSO, controller, dan model tidak diubah.

> Hallmark · pre-emit critique: Philosophy 5 · Hierarchy 5 · Execution 5 · Specificity 5 · Restraint 5 · Variety 4

---

## 1. Tujuan dan batasan

Redesign ini membuat JARSIPLUS terasa sebagai layanan digital Pemerintah Kota Samarinda: jelas, tenang, dapat dipercaya, dan mudah digunakan untuk mengajukan serta memantau inovasi daerah. Redesign hanya mengganti lapisan visual dan interaksi frontend; seluruh perilaku bisnis harus tetap parity.

### Dalam cakupan

- Halaman publik: Beranda, Informasi, Statistik, FAQ, dan Maintenance.
- Portal pemohon: daftar permohonan, buat permohonan, detail, serta pola visual yang dapat dipakai halaman pemohon lanjutan.
- Shell aplikasi, token CSS, komponen Vue bersama, state interaksi, aksesibilitas, dan responsivitas.

### Di luar cakupan

- Visual, markup, route, maupun alur e-panel `jarsiplus/*` yang masih memakai Nue/Blade.
- Perubahan kontrak props Inertia, endpoint, autentikasi SSO, validasi server, payload form, atau struktur data.
- Penambahan angka, testimoni, penghargaan, foto, atau klaim yang tidak tersedia dari data resmi.

---

## 2. Rujukan dan aturan anti-plagiarisme

Intel dipakai sebagai referensi publik untuk membaca prinsip, bukan sebagai sumber desain yang disalin. Yang diadopsi hanya: hierarki konten yang tegas, kontras permukaan yang disiplin, CTA yang jelas, dan perhatian pada konten terkini. Implementasi JARSIPLUS wajib memiliki bentuk, identitas, dan interaksi sendiri.

| Boleh dipelajari | Wajib berbeda pada JARSIPLUS |
| --- | --- |
| Urutan perhatian: pesan utama → aksi → informasi pendukung | Hero menjadi komposisi dokumen sipil dengan motif Mahakam, bukan carousel promosi produk |
| Penggunaan permukaan terang/gelap sebagai penekanan | Palet teal Mahakam, amber, dan ink navy; bukan Intel blue/cyan dan hitam Intel |
| Kerapian navigasi serta CTA | Header kompak layanan pemerintahan, bukan mega-menu atau navigasi produk Intel |
| Disiplin tipografi dan whitespace | Plus Jakarta Sans + Inter; bukan Intel One atau pengaturan tipografi Intel |

### Larangan eksplisit

- Tidak memakai logo, foto, copy, nama produk, font, warna, tombol, layout, footer, kartu berita, atau carousel Intel.
- Tidak memakai autoplay carousel, mega-menu, hero gambar produk, pseudo browser/device frame, glow neon, glassmorphism, atau gradient teks.
- Tidak membuat metrik fiktif. Statistik selalu memakai props backend; data yang belum ada menampilkan `—` dengan konteks yang jujur.
- Tidak menggunakan aset foto stok sebagai representasi resmi Samarinda. Visual utama memakai motif abstrak orisinal sampai aset resmi disediakan.

---

## 3. Konsep: Mahakam Civic Innovation

**Genre**: modern-minimal civic editorial.
**Karakter**: terang, formal tanpa kaku, lokal tanpa ornamen berlebihan, dan fungsional untuk pekerjaan administrasi.

Sistem visual memakai analogi aliran Mahakam: jalur tipis mewakili perjalanan usulan, titik/simpul mewakili bukti dan tahapan, serta bidang solid mewakili keputusan. Motif dibuat sebagai SVG atau CSS sederhana; ia hanya muncul pada hero publik, pembatas section, dan maintenance—bukan pada form kerja pemohon.

### Keluarga struktur halaman

| Keluarga | Bentuk | Dipakai pada |
| --- | --- | --- |
| Civic briefing | Hero naratif, ringkasan data, jalur proses, tindakan berikutnya | Beranda |
| Long document | Judul, navigasi konteks, isi terbaca, CTA penutup | Informasi dan FAQ |
| Public ledger | Ringkasan angka, status, penjelasan data | Statistik |
| Applicant workbench | Header konteks, tindakan, status, data/field bertahap | Semua halaman pemohon |

---

## 4. Sistem token

`resources/css/tokens.css` adalah sumber nilai kanonis. Halaman Vue dan komponen tidak boleh memakai warna atau font literal; gunakan token atau utility Tailwind yang memetakan token tersebut.

### 4.1 Warna

| Peran | Token | Nilai | Pemakaian |
| --- | --- | --- | --- |
| Kanvas | `--paper` | `#F7F5F0` | Latar utama terang |
| Permukaan | `--surface` | `#FFFFFF` | Kartu, panel, menu |
| Permukaan gelap | `--surface-strong` | `#14202B` | Jalur penekanan dan footer |
| Teks utama | `--ink-900` | `#14202B` | Heading dan isi penting |
| Teks sekunder | `--ink-600` | `#3E4C57` | Isi dan label |
| Teks redup | `--ink-400` | `#71808A` | Caption dan metadata |
| Garis | `--line` | `#E5E1D8` | Border dan pembatas |
| Brand | `--brand-500` | `#0E8F79` | CTA utama, tautan, fokus konteks |
| Brand hover | `--brand-600` | `#0A6E5D` | Hover/active CTA utama |
| Brand lembut | `--brand-50` | `#E9F6F2` | Latar status/panel ringan |
| Aksen | `--accent-400` | `#F2B441` | Highlight terbatas, bukan CTA utama global |
| Fokus | `--color-focus` | `#0E8F79` | Ring keyboard minimal 2px |

Status menggunakan token yang telah ada (`success`, `warning`, `danger`, `info`) dengan pasangan latar masing-masing. Warna status tidak menjadi satu-satunya pembeda: setiap badge memiliki label teks.

### 4.2 Tipografi dan ruang

- Display/UI: `--font-heading`: Plus Jakarta Sans, bobot 600–800, roman saja.
- Body: `--font-body`: Inter, bobot 400–700, line-height long-form minimal 1.6.
- Angka statistik memakai `font-variant-numeric: tabular-nums`.
- Skala ruang: kelipatan 4 px. Tambahkan token `--space-3xs` sampai `--space-4xl`; section memakai 56 px pada mobile dan 96 px pada desktop.
- Radius: kartu 16 px, input/tombol 10 px, badge 8 px. Radius pill hanya untuk status/penanda kecil, bukan seluruh UI.
- Bayangan: ringan dan netral; elevasi bertambah saat interaksi tanpa glow berwarna.

### 4.3 Motion dan responsif

- Durasi: 180 ms cepat, 240 ms standar, 320 ms maksimum; gunakan token easing yang bernama.
- Hanya `transform`, `opacity`, dan warna yang bertransisi. Tidak ada scroll-jacking atau autoplay.
- Pada `prefers-reduced-motion`, hilangkan perpindahan spasial; gunakan perubahan opacity maksimal 150 ms.
- `html` dan `body` memakai `overflow-x: clip`. Verifikasi lebar 320, 375, 414, dan 768 px.

---

## 5. Shell dan komponen bersama

### AppLayout

- Header floating yang ringkas di atas kanvas: wordmark JARSIPLUS, navigasi Beranda/Informasi/Statistik/FAQ, CTA Portal Pemohon, dan tautan teks E-Panel Admin.
- E-Panel Admin ditampilkan sebagai tautan keluar yang jelas dan tidak menyerap gaya atau markup e-panel.
- Mobile memakai tombol menu berlabel aksesibel, `aria-expanded`, `aria-controls`, fokus yang dapat ditutup dengan Escape, dan menu satu kolom.
- Footer memakai pernyataan institusi ringkas, tautan layanan, dan copyright. Tidak ada mega-footer atau sitemap berkolom.

### Primitive Vue

| Komponen | Tanggung jawab |
| --- | --- |
| `Card` | Permukaan data berborder, elevasi ringan; varian `default`, `quiet`, `interactive` |
| `StatTile` | Nilai aktual, label, caption; mendukung status kosong `—` |
| `Badge` | Status dengan label, warna, dan ikon opsional yang tidak berdiri sendiri |
| `Button` | Varian primary, secondary, quiet/destructive; ukuran sm/md; loading dan disabled |
| `EmptyState` | Keadaan kosong tanpa ilustrasi generik; CTA hanya bila aksi tersedia |
| `Field` | Label, petunjuk, pesan error, dan state validasi yang konsisten |
| `Accordion` | FAQ dengan tombol semantik, `aria-expanded`, panel terhubung, keyboard operasional |
| `FlowMotif` | Motif SVG/CSS abstrak Mahakam; hanya dekoratif (`aria-hidden`) |

Komponen interaktif harus memiliki state default, hover, focus-visible, active, disabled, loading, error, dan success bila relevan. Loading tidak memindahkan tata letak; error ditautkan ke field dengan `aria-describedby`.

---

## 6. Spesifikasi per route

### Beranda — `Pages/Welcome.vue`

1. Hero civic briefing: judul layanan, deskripsi singkat, CTA `Ajukan Inovasi Daerah`, CTA sekunder `Pelajari Alur`, dan `FlowMotif` pada sisi/belakang komposisi.
2. Ringkasan angka dari props `permohonanCount`, `prosesCount`, dan `setujuCount`; semua nilai tetap dari backend.
3. Jalur tiga tahap: daftarkan → lengkapi bukti → verifikasi dan pemetaan. Gunakan garis alur, bukan tiga kartu SaaS seragam.
4. Penutup ajakan menuju portal pemohon dengan penjelasan singkat tentang kesiapan dokumen.

### Informasi — `Pages/Informasi/Index.vue`

- Bentuk long document: intro, daftar tahap, konten pedoman, dan CTA portal pemohon.
- Pada desktop, navigasi konteks boleh tetap dekat judul; pada mobile menjadi daftar ringkas di atas isi, tanpa sidebar kecil yang tidak terbaca.
- Konten `Laman` dinamis di masa depan memakai container baca dengan panjang baris nyaman, heading semantik, dan tabel responsif.

### Statistik — `Pages/Statistik/Index.vue`

- Hero singkat yang menjelaskan asal data dan waktu cakupan bila props tersedia.
- Grid StatTile menampilkan total usulan, proses, tervalidasi, dan jumlah pemohon tanpa grafik baru yang belum didukung data.
- Keterangan status menjelaskan arti setiap angka supaya statistik tidak menjadi dekorasi angka semata.

### FAQ — `Pages/Faq/Index.vue`

- Intro singkat dan daftar accordion satu kolom.
- Satu item terbuka dalam satu waktu sebagai default; pengguna dapat menutupnya kembali.
- Pencarian/kategori hanya ditambahkan jika data FAQ dan kebutuhan filter memang tersedia dari backend.

### Maintenance — `Pages/Maintenance.vue`

- Satu pesan layanan, alasan singkat yang tidak spekulatif, dan CTA kembali ke beranda.
- Motif Mahakam dipakai minimal sebagai pembeda visual, tanpa informasi waktu pemulihan yang tidak diberikan.

### Permohonan — `Pages/Permohonan/*.vue`

| Route/view | Bentuk redesign | Data dan aksi yang dipertahankan |
| --- | --- | --- |
| Index | Header workbench, tombol tambah jelas, daftar kartu responsif dengan badge status dan metadata | `permohonan`, link detail, link create |
| Create | Breadcrumb, penjelasan sebelum mulai, field terkelompok, action bar stabil | `useForm`, payload dan POST ke `/permohonan` |
| Detail | Header judul + status, metadata, panel deskripsi, slot perluasan indikator/riwayat | prop `item`, link kembali |

Halaman pemohon tidak menggunakan hero dekoratif. Prioritasnya adalah orientasi, status, field, dan tindakan berikutnya.

---

## 7. Langkah implementasi

1. **Sinkronkan dokumen desain**
   - Jadikan dokumen ini referensi implementasi.
   - Ganti isi `design.md` lama yang masih membawa DNA Intel dengan sistem Mahakam Civic Innovation ini.
   - Pastikan `design.md`, `docs/redesign.md`, `tokens.css`, dan Tailwind tidak memiliki palet/font yang saling bertentangan.

2. **Bangun fondasi token**
   - Rapikan `resources/css/tokens.css` menjadi token semantik lengkap: warna, font, ruang, radius, shadow, motion, dan focus.
   - Perbarui `resources/css/app.css` untuk base style, reset responsif, focus ring, reduced motion, dan utility komponen; jangan menghapus directive Tailwind.
   - Selaraskan `tailwind.config.js` dengan token Mahakam agar utility yang baru tidak membawa hex/font inline.

3. **Refactor shell dan primitive**
   - Perbarui `AppLayout.vue`, `Card.vue`, `StatTile.vue`, dan `Badge.vue` terlebih dahulu.
   - Tambahkan primitive hanya saat dipakai (`Button`, `EmptyState`, `Field`, `Accordion`, `FlowMotif`) agar tidak menciptakan library kosong.
   - Pisahkan kelas presentasi dari markup halaman dan pertahankan public API props komponen yang ada.

4. **Redesign halaman publik**
   - Urutan: Welcome → Informasi → Statistik → FAQ → Maintenance.
   - Terapkan struktur pada Bab 6, hubungkan CTA ke route yang sudah ada, dan jangan mengubah controller/props.
   - Uji setiap route sebelum melanjutkan ke route berikutnya.

5. **Redesign portal pemohon**
   - Urutan: Index → Create → Detail.
   - Pertahankan `useForm`, URL submit, props `permohonan`/`item`, dan perilaku link.
   - Tambahkan state kosong, invalid, processing, sukses, dan error melalui kemampuan Inertia yang sudah ada—tanpa mengubah kontrak backend.

6. **QA dan penguncian sistem**
   - Jalankan build, cek mobile/keyboard/kontras, serta smoke test pengajuan.
   - Verifikasi e-panel Nue secara visual dan fungsional tidak berubah.
   - Tambahkan komentar cap sistem desain pada stylesheet setelah hasil lolos audit.

---

## 8. Kriteria penerimaan

- [ ] `npm run build` berhasil tanpa perubahan pada route/controller/API/SSO.
- [ ] Semua halaman publik dan pemohon memakai token bernama; tidak ada warna/font literal baru dalam page component.
- [ ] Beranda menampilkan hanya statistik dari props dan tidak memiliki carousel/autoplay.
- [ ] Form pengajuan tetap mengirim payload dan menampilkan state processing/error dengan benar.
- [ ] Navigasi desktop/mobile, FAQ accordion, badge status, empty state, dan CTA dapat dioperasikan keyboard.
- [ ] Kontras teks, border, dan focus ring memenuhi WCAG AA; target kontrol sentuh minimal 44 × 44 px bila memungkinkan.
- [ ] Tidak ada horizontal scroll pada 320/375/414/768 px; CTA, breadcrumb, dan tautan navigasi tidak pecah menjadi dua baris.
- [ ] E-panel admin Nue tetap sama secara visual dan fungsional.
- [ ] Tidak ada elemen visual atau copy yang meniru Intel secara langsung.

---

## 9. Urutan commit yang disarankan

1. `docs: define Mahakam civic redesign system`
2. `style: align public frontend tokens and base styles`
3. `refactor: rebuild shared public layout primitives`
4. `feat: redesign public Inertia pages`
5. `feat: redesign applicant workbench views`
6. `test: verify responsive accessibility and parity`
