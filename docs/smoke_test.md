# Manual Smoke Test Suite — JARSIPLUS 2026

## Overview
Panduan smoke test manual untuk memverifikasi fungsionalitas utama aplikasi JARSIPLUS setelah perombakan framework ke Laravel 12 + PHP 8.4 dan migrasi Inertia/Vue 3.

---

## 1. Landing Page & Halaman Publik
- [ ] **Home (`/`)**: Menampilkan carousel/slider banner, statistik kerjasama, dan footer logo Samarinda.
- [ ] **Informasi (`/informasi`)**: Menampilkan daftar dokumen informasi kerjasama.
- [ ] **Statistik (`/statistik`)**: Menampilkan visualisasi chart data statistik kerjasama.
- [ ] **FAQ (`/faq`)**: Menampilkan accordion FAQ publik.

---

## 2. Autentikasi & SSO
- [ ] **Login Admin (`/login` / `/sso/login`)**: Berhasil melakukan autentikasi login via SSO Samarinda atau credentials lokal.
- [ ] **Middleware AutoLogin (`SSOAutoLogin`)**: Sesi login otomatis sinkron tanpa *infinite redirect loop*.
- [ ] **Logout (`/logout`)**: Sesi berhasil dihancurkan dan dialihkan kembali ke landing page.

---

## 3. E-Panel Admin Nue (`/jarsiplus/*`)
- [ ] **Dashboard Admin (`/jarsiplus/permohonan`)**: Menampilkan daftar pengajuan kerjasama (DataTables).
- [ ] **Manajemen Pemohon (`/jarsiplus/pemohon`)**: Berhasil melakukan CRUD data pemohon kerjasama.
- [ ] **Log Permohonan (`/jarsiplus/logpermohonan`)**: Menampilkan audit trail riwayat status permohonan.
- [ ] **Penjadwalan Persetujuan (`/jarsiplus/permohonan/{permohonan}/persetujuan`)**: Menampilkan kalendar/form persetujuan.
- [ ] **File & Pembahasan (`/jarsiplus/file.pembahasan`)**: Mengunggah berkas rancangan kerjasama dan mencatat komentar pembahasan.
- [ ] **Validasi Berkas (`/jarsiplus/file.validasi`)**: Melakukan verifikasi dan validasi status dokumen.

---

## 4. Area Pemohon Portal
- [ ] **Daftar Permohonan Saya (`/permohonan`)**: Menampilkan permohonan yang diajukan oleh akun terpaut.
- [ ] **Pengajuan Permohonan Baru (`/permohonan/create`)**: Membuka form multi-step/wizard pengajuan baru.
- [ ] **Upload Berkas (`/permohonan/{id}/berkas`)**: Mengunggah dokumen persyaratan PDF/Image.
- [ ] **Detail & Riwayat (`/permohonan/{uuid}/detail`)**: Menampilkan timeline progress pengajuan.
