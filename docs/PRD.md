# PRD — Modernisasi JARSIPLUS 2026

**Dokumen**: Product Requirements Document
**Produk**: JARSIPLUS (Jaringan Inovasi Plus Daerah Kota Samarinda)
**Versi dokumen**: 1.0
**Tanggal**: 2026-07-27
**Status**: Draft untuk persetujuan

---

## 1. Latar Belakang

JARSIPLUS adalah aplikasi e-government Pemerintah Kota Samarinda untuk pengajuan dan
penilaian inovasi daerah (`https://jarsiplus.samarindakota.go.id`). Aplikasi berjalan di
Laravel 8 dengan frontend Blade + Laravel Mix dan berstatus PWA. Codebase merupakan hasil
fork dari aplikasi lama **SIKERJA**, sehingga masih menyimpan jejak nama lama (prefix route,
path storage, aset) dan sebuah alur ganda "Beimbai" yang tidak lengkap.

Kondisi teknis saat ini menua: Laravel 8 sudah lewat masa dukungan, PWA tidak lagi
dibutuhkan, dan tumpukan frontend Blade menyulitkan pengembangan. Dibutuhkan modernisasi
menyeluruh tanpa mengubah fungsi yang sudah berjalan.

## 2. Tujuan Produk

Memodernkan JARSIPLUS agar aman, mudah dirawat, dan cepat dikembangkan, dengan menjaga
seluruh fungsi yang ada (parity), tanpa mengubah pengalaman staf pada panel admin.

### Tujuan spesifik
1. Meng-upgrade backend ke Laravel versi terbaru dan PHP 8.3 secara bertahap dan aman.
2. Merombak total frontend publik dan area pemohon menjadi Inertia + Vue 3 (Vite).
3. Menghapus status PWA sepenuhnya.
4. Membersihkan seluruh jejak SIKERJA dan menghapus alur penjurian Beimbai yang tidak dipakai.
5. Menjaga panel admin (Nue) tetap berfungsi dengan tampilan dan alur yang sama persis.

## 3. Ruang Lingkup

### Dalam lingkup (In scope)
- Upgrade Laravel 8 → 12 (in-place, bertahap) dan PHP → 8.3 (8.4 opsional).
- Rebuild frontend **publik** (landing, informasi, statistik, FAQ) → Inertia + Vue 3.
- Rebuild **area pemohon terautentikasi** (ajukan permohonan, unggah berkas, pembahasan,
  riwayat, kirim, pengaturan akun) → Inertia + Vue 3.
- Penghapusan PWA (serviceworker, manifest, paket laravelpwa).
- Pembersihan sisa SIKERJA (prefix route, branding, aset orphan).
- Penghapusan penjurian Beimbai (controller, route, entity stub).
- Perbaikan kompatibilitas teknis panel admin Nue agar jalan di Laravel baru.

### Di luar lingkup (Out of scope / Non-goals)
- **Redesain visual atau alur panel admin (Nue).** Panel admin hanya disesuaikan secara
  teknis; tampilan tetap sama.
- **Penambahan fitur baru.** Rilis ini murni parity.
- Penggantian panel admin ke framework lain (mis. Filament) — dicatat sebagai kandidat fase lanjutan.
- Perubahan skema data domain di luar yang dibutuhkan upgrade.
- Migrasi total path storage `sikerja/` (opsional, butuh migrasi data terpisah).

## 4. Aktor / Pengguna

| Aktor | Deskripsi | Area |
|---|---|---|
| Publik | Pengunjung tanpa login | Halaman publik (rebuild) |
| Pemohon | Pengaju inovasi (login via SSO) | Area pemohon (rebuild) |
| Admin / Verifikator | Staf pemerintah yang menilai & membahas | Panel admin Nue (dijaga) |
| Juri | Penilai inovasi (feed API) | Integrasi juri (dijaga) |

## 5. Kebutuhan Produk (ringkas — detail di SRS)

### 5.1 Halaman publik
- Landing, Informasi (dinamis dari `laman`), Statistik, FAQ, halaman maintenance.

### 5.2 Area pemohon
- Autentikasi via SSO Samarinda.
- Ajukan permohonan inovasi (form multi-segmen), unggah berkas/bukti dukung per indikator.
- Lihat detail, ikuti pembahasan (chat/diskusi), riwayat, kirim final, persetujuan.
- Pengaturan akun / profil / data korporasi.

### 5.3 Panel admin (dijaga, tidak diredesain)
- Kelola permohonan, penilaian, pembahasan, validasi, penjadwalan, arsip.
- Master data: kategori, urusan, indikator, parameter.
- Kelola pemohon, slider, laman, FAQ.

### 5.4 Integrasi
- SSO `sso.samarindakota.go.id` (wajib tetap berfungsi).
- Feed juri (`juri-jarsiplus.samarindakota.go.id`) — dipertahankan.
- Realtime pembahasan (saat ini socket.io) — dipertahankan fungsinya (keputusan teknis di SRS).

## 6. Kebutuhan Non-Fungsional

- **Kompatibilitas**: Laravel target (12, fallback 11) + PHP 8.3.
- **Keamanan**: hapus secret dari repo (`.env`, `database_dump.sql`), rotasi kredensial,
  pertahankan SSO.
- **Pemeliharaan**: struktur modul rapi, buang kode mati (SIKERJA, Beimbai penilaian).
- **Performa**: build Vite, tanpa overhead PWA.
- **Parity**: perilaku fungsional identik dengan versi lama.

## 7. Batasan & Asumsi

- Panel admin Nue harus tetap hidup; bila Nue tidak kompatibel Laravel 12, dilakukan
  fork/patch lokal, atau fallback ke Laravel 11 (dikonfirmasi saat eksekusi).
- Brand tetap JARSIPLUS; domain, DB (`jarsiplus_main`), dan SSO broker tidak berubah.
- Data produksi (file unggahan di path `sikerja/`) tidak boleh rusak.

## 8. Kriteria Sukses

1. Aplikasi berjalan di PHP 8.3 + Laravel target tanpa error.
2. Seluruh alur pemohon & publik berfungsi identik dengan versi lama (parity), kini di Vue.
3. Panel admin berfungsi & tampil sama persis.
4. Tidak ada PWA aktif, tidak ada jejak SIKERJA di kode, penjurian Beimbai hilang.
5. SSO login (pemohon & staf) sukses.

## 9. Risiko Utama

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Nue tak support Laravel 12 | Panel admin rusak | Fork/patch lokal; fallback L11 |
| SSO client tak kompatibel | Login gagal total | Uji dini; fork/patch; pin versi |
| intervention/image v2→v3 | Fitur unggah/olah gambar rusak | Refactor pemakaian API |
| Regресi parity saat port Blade→Vue | Fungsi berubah | Smoke test per alur, bandingkan lama vs baru |

## 10. Milestone

| Fase | Keluaran |
|---|---|
| 0 | Baseline git, backup, migration dari dump, daftar smoke test |
| 1 | Upgrade Laravel 8→12 + PHP 8.3, blocker Nue/SSO teratasi |
| 2 | Sisa SIKERJA bersih, penjurian Beimbai terhapus |
| 3 | Frontend publik + pemohon di Inertia/Vue, PWA dibuang |
| 4 | QA parity, rilis |
