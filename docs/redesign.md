# Redesign Frontend — JARSIPLUS 2026

**Dokumen**: Design & Redesign Plan (frontend publik + pemohon)
**Versi**: 1.0
**Tanggal**: 2026-07-27
**Rujukan**: PRD.md, SRS.md
**Lingkup**: HANYA frontend publik & area pemohon (Inertia/Vue). **Epanel (Nue/Blade) TIDAK disentuh.**

---

## 1. Konteks & Masalah

Frontend saat ini (Vue 3 + Inertia + Tailwind) memakai bahasa visual **template SaaS gelap generik**:
dasar `slate-950`, teks gradient `blue→indigo→purple`, glassmorphism `backdrop-blur`, hero standar.
Tampilan ini terasa meniru website referensi sehingga berisiko dianggap **plagiat** dan tidak
mencerminkan identitas Pemkot Samarinda.

**Tujuan redesign**: bangun identitas visual **original & lokal** (khas Samarinda / pemerintahan),
berbeda tegas dari referensi, sambil **menjaga seluruh fungsi & data (parity)** — hanya lapisan
presentasi yang berubah. Logika controller, props Inertia, dan route tidak diubah.

---

## 2. Prinsip Desain (arah baru)

1. **Light-first, resmi tapi hangat** — kanvas terang, lapang, editorial. Bukan dark-tech.
2. **Identitas lokal Samarinda** — warna & motif terinspirasi Sungai Mahakam + kehangatan
   khatulistiwa, bukan palet biru-korporat generik.
3. **Kejelasan > dekorasi** — hierarki tipografi kuat, whitespace murah hati, komponen fungsional.
4. **Aksesibel** — kontras WCAG AA, fokus keyboard jelas, target sentuh ≥44px.
5. **Konsisten** — satu set token (warna, spasi, radius, bayangan) dipakai seluruh halaman.
6. **Ringan** — tanpa efek berat (blur besar, gradient bertumpuk); animasi halus & bermakna.

---

## 3. Anti-Plagiat: yang DIBUANG vs yang DIPAKAI

| Marker referensi (BUANG) | Ganti dengan (ORIGINAL) |
|---|---|
| Dasar gelap `bg-slate-950` | Kanvas terang `#F7F5F0` (warm paper) + mode gelap sekunder opsional |
| Teks gradient `blue→indigo→purple` | Warna solid + aksen tunggal; heading tanpa gradient-clip |
| Glassmorphism `backdrop-blur` kartu | Kartu solid, bayangan lembut berlapis (soft elevation) |
| Palet biru-korporat generik | Palet **Mahakam**: teal-hijau (inovasi) + amber (hangat) + navy tua (otoritas) |
| Bootstrap Icons `bi-*` | Ikon garis konsisten (Lucide / Phosphor) — set berbeda, stroke seragam |
| Hero SaaS "big gradient headline" | Hero editorial: eyebrow + judul serif/humanis + ilustrasi motif sungai |
| Sudut pill berlebihan + shadow neon | Radius terukur (8–16px) + bayangan natural (bukan glow warna) |
| Font sistem default | Pasangan tipografi khas (heading + body) berbeda dari referensi |

Prinsip: bila referensi "gelap-glossy-korporat", arah baru "**terang-editorial-lokal**". Perbedaan
harus terbaca dalam 3 detik pertama.

---

## 4. Design Tokens

### 4.1 Warna (tema "Mahakam")
```
Brand / Inovasi (utama)   teal-hijau
  --brand-50   #E9F6F2
  --brand-500  #0E8F79   (aksi utama, link)
  --brand-600  #0A6E5D   (hover)
  --brand-900  #08302A
Aksen / Hangat (highlight, CTA sekunder, status)
  --accent-400 #F2B441   (amber Samarinda)
  --accent-600 #C8871B
Otoritas / Teks (navy tua, formal)
  --ink-900    #14202B   (heading)
  --ink-600    #3E4C57   (body)
  --ink-400    #71808A   (muted)
Kanvas
  --paper      #F7F5F0   (background utama, warm)
  --surface    #FFFFFF   (kartu)
  --line       #E5E1D8   (border halus)
Status
  success #1E9E6A   warning #C8871B   danger #C0442E   info #2C6E9B
```
Dark mode (sekunder, opsional): kanvas `#101816`, surface `#16211E`, brand naik ke `#2CB7A0`.

### 4.2 Tipografi
- **Heading**: *Plus Jakarta Sans* (buatan Indonesia — perkuat identitas lokal & orisinalitas).
- **Body**: *Inter* atau *Source Sans 3* (netral, terbaca).
- Skala: `36/30/24/20/16/14/12`. Heading `font-bold tracking-tight`, body `leading-relaxed`.
- Angka statistik: tabular-nums, berat extrabold.

### 4.3 Spasi, radius, elevasi
- Spasi grid 4px; section vertical rhythm `96px` desktop / `56px` mobile.
- Radius: kartu `16px`, tombol/input `10px`, chip `8px`.
- Bayangan berlapis lembut: `0 1px 2px rgba(20,32,43,.06), 0 8px 24px rgba(20,32,43,.06)` — **bukan** glow warna.
- Container maksimum `1200px`, gutter `24px`.

### 4.4 Motif original
Garis alur sungai (flow line) tipis sebagai pembatas section + pola geometris terinspirasi
**sarung Samarinda** (motif tenun) sebagai tekstur aksen halus di hero/footer. Dibuat sendiri
(SVG), bukan aset template.

---

## 5. Komponen Inti (buat sebagai Vue components reusable)

Simpan di `resources/js/Components/`:
- `AppLayout.vue` — shell publik (navbar terang + footer motif) menggantikan header/footer yang kini di-inline tiap halaman.
- `Button.vue` — varian: `primary` (brand), `accent`, `ghost`, `outline`; ukuran sm/md/lg.
- `Card.vue` / `StatTile.vue` — kartu solid + StatTile untuk angka statistik.
- `Badge.vue` — status permohonan (draft/proses/setuju/tolak) pakai warna status.
- `Stepper.vue` — indikator tahap form Permohonan (multi-segmen).
- `Timeline.vue` — riwayat & pembahasan (pengganti tampilan chat generik).
- `Field.vue` / `FileDrop.vue` — input & unggah berkas konsisten.
- `EmptyState.vue`, `Skeleton.vue` — kondisi kosong & loading.
- `Icon.vue` — bungkus set ikon Lucide/Phosphor (satu sumber, stroke seragam).

Aturan: semua warna via token Tailwind (extend theme), tak ada hex hardcoded di halaman.

---

## 6. Redesign per Halaman (parity fungsi dijaga)

Props Inertia & data dari controller **tidak berubah** — hanya markup/gaya.

| Halaman | File | Arah redesign |
|---|---|---|
| Beranda | `resources/js/Pages/Welcome.vue` | Hero editorial (eyebrow + judul + motif sungai), 3 StatTile solid, blok alur 3 langkah, CTA ganda (Portal Pemohon / Informasi). Buang dark+gradient. |
| Informasi | `Pages/Informasi/Index.vue` | Layout artikel/dokumen: sidebar daftar isi + konten `laman`, tipografi baca nyaman. |
| Statistik | `Pages/Statistik/Index.vue` | Dashboard terang: StatTile + grafik ringkas (bar/line), warna status konsisten. |
| FAQ | `Pages/Faq/Index.vue` | Accordion bersih, pencarian, kategori chip. |
| Permohonan (list) | `Pages/Permohonan/Index.vue` | Tabel/kartu status pakai `Badge`, filter, EmptyState. |
| Permohonan (buat) | `Pages/Permohonan/Create.vue` | `Stepper` multi-segmen, `Field`/`FileDrop`, ringkasan sebelum kirim. |
| Permohonan (detail) | `Pages/Permohonan/Detail.vue` | Header status + `Timeline` (riwayat/pembahasan) + panel berkas/indikator. |
| Maintenance | `Pages/Maintenance.vue` | Halaman tenang bermotif, pesan jelas. |
| Pengaturan akun | (tambah jika ada route settings) | Form profil/korporasi pakai `Field`. |

**Navigasi**: pisahkan tegas "Portal Pemohon" (frontend ini) vs tautan "E-Panel Admin"
(Nue, buka tab/route terpisah) — epanel tetap tak diubah.

---

## 7. Rencana Implementasi (bertahap)

1. **Fondasi token & tooling**
   - Extend `tailwind.config.js`: warna Mahakam, font, radius, shadow, container.
   - Pasang font (Plus Jakarta Sans + Inter) via `@fontsource` (self-host, tanpa CDN eksternal).
   - Pasang set ikon (lucide-vue-next / phosphor) → buat `Icon.vue`. Lepas dependensi Bootstrap Icons.
   - Definisikan variabel CSS + base style di `resources/css/app.css`.
2. **Komponen inti** — bangun komponen di Bab 5 + `AppLayout.vue`.
3. **Migrasi halaman** — refactor tiap halaman ke `AppLayout` + komponen + token. Urutan:
   Welcome → Informasi → Statistik → FAQ → Permohonan(Index→Create→Detail) → Maintenance.
   Jaga props & alur; hanya presentasi berubah.
4. **Mode gelap opsional** — jika diminta, aktifkan via `class` strategy Tailwind (fase akhir).
5. **QA visual & fungsi** — bandingkan tiap halaman: fungsi parity, cek kontras & responsif.

**Prinsip aman**: satu halaman satu commit; parity diverifikasi sebelum lanjut.

---

## 8. Verifikasi

- [ ] `npm run build` sukses; tak ada dependensi CDN eksternal (font/ikon self-host).
- [ ] Tiap halaman publik+pemohon tampil identik fungsi dengan versi lama (form kirim, unggah, filter jalan).
- [ ] Epanel (Nue) **tidak berubah** sama sekali.
- [ ] Audit visual: tak ada lagi `slate-950` base, gradient-clip heading, atau `backdrop-blur` glassmorphism.
- [ ] Kontras teks/latar lulus WCAG AA; navigasi keyboard & fokus terlihat.
- [ ] Responsif mobile (≤375px) sampai desktop (≥1440px).

---

## 9. Keputusan
- Tema warna final: **Mahakam (teal+amber)** — setujui atau ganti arah?
- Perlu mode gelap sekunder dan light-only
- Set ikon:  Phosphor.
- Perlu grafik di Statistik
