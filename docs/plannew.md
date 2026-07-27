Redesign JARSIPLUS: Publik & Portal Pemohon
Ringkasan
Buat docs/redesign.md sebagai spesifikasi visual dan UX utama untuk seluruh frontend Inertia/Vue: beranda, informasi, statistik, FAQ, maintenance, serta alur pemohon. E-panel admin Blade/Nue dan seluruh route, API, SSO, serta logika backend tidak berubah.
Referensi Intel dipakai hanya untuk prinsip hierarki korporat dan disiplin konten; tidak meniru palet cyan, font Intel, carousel, mega-menu, tata letak, aset, atau komponen mereka. Sistem baru memakai identitas orisinal “Mahakam Civic Innovation”.
Sistem desain yang dikunci
Ganti total design.md lama agar selaras dengan docs/redesign.md; jadikan keduanya sumber kebenaran tunggal untuk frontend publik/pemohon.
Tema: light-first dengan permukaan putih hangat, ink navy-hijau, teal Mahakam sebagai aksi utama, amber terbatas untuk perhatian/status, dan bidang navy gelap hanya sebagai penekanan.
Tipografi: Plus Jakarta Sans untuk display/UI dan Inter untuk isi; semua token warna, ruang, radius, bayangan, type scale, dan motion bernama di resources/css/tokens.css.
Motif hero: SVG/CSS abstrak orisinal yang menerjemahkan aliran Sungai Mahakam menjadi simpul, jalur, dan lapisan data inovasi—tanpa foto stok atau aset turunan Intel.
Navigasi: header kompak dengan wordmark, tautan publik, CTA Portal Pemohon, serta tautan E-Panel Admin yang diperlakukan sebagai pintu keluar; menu mobile aksesibel dengan fokus terkelola.
Footer: pernyataan institusional ringkas Pemerintah Kota Samarinda, tautan layanan publik, dan akses e-panel; bukan mega-footer korporat.
Motion: transisi pendek dan fungsional, tanpa autoplay; semua interaksi menghormati prefers-reduced-motion.
Struktur halaman dan komponen
Beranda memakai struktur “civic briefing”: hero + CTA → status/angka nyata → peta alur pengajuan → pengantar pedoman/FAQ. Angka hanya berasal dari props backend; nilai yang belum tersedia tidak dibuat-buat.
Informasi memakai struktur dokumen terarah: ringkasan tujuan, navigasi jangkar/daftar isi, tahapan, indikator, dan CTA ke portal pemohon.
Statistik memakai dashboard publik yang tenang: ringkasan angka, konteks arti status, dan state kosong yang jujur; tanpa grafik atau klaim baru bila datanya belum disediakan.
FAQ menjadi accordion aksesibel dengan state buka/tutup, fokus keyboard, dan dukungan data dinamis saat endpoint tersedia.
Maintenance menjadi status layanan ringkas dengan informasi yang tersedia dan jalur kembali yang jelas.
Portal pemohon memakai keluarga “workbench”: header konteks, breadcrumb, status usulan, aksi utama jelas, kartu data secukupnya, form bersegmen, dan progress/empty/error/loading states. Tidak memakai motif dekoratif hero pada halaman kerja.
Perbarui AppLayout.vue, Card.vue, StatTile.vue, dan Badge.vue menjadi primitive bersama; halaman Vue hanya menyusun konten dan data, bukan mengulang kelas warna mentah.
Semua tombol, input, badge, accordion, menu mobile, dan form memiliki state default, hover, focus-visible, active, disabled, loading, error, dan success sesuai relevansi.
Implementasi dan kompatibilitas
Selaraskan resources/css/tokens.css, resources/css/app.css, dan konfigurasi Tailwind dengan token baru; hilangkan hex/font inline dari halaman Vue secara bertahap.
Terapkan ulang tampilan pada resources/js/Pages/** dan komponen bersama tanpa mengubah nama route, kontrak props Inertia, submission form, autentikasi SSO, atau link e-panel.
Tambahkan cap Hallmark pada stylesheet sistem yang menyatakan genre modern-minimal, sistem desain design.md, dan cakupan publik/pemohon.
docs/redesign.md memuat: prinsip orisinalitas, token lengkap, aturan tipografi/spacing/motion, layout per route, spesifikasi komponen dan state, aturan konten/data, responsivitas, aksesibilitas, serta daftar elemen yang dilarang ditiru dari referensi.
Pengujian penerimaan
Verifikasi seluruh route publik dan pemohon tetap merender dengan props serta aksi lama.
Uji responsif di lebar 320, 375, 414, dan 768 px: tanpa horizontal scroll, navigasi/CTA tidak pecah dua baris, dan form tetap dapat digunakan.
Uji keyboard, focus-visible, kontras, menu mobile, accordion FAQ, form invalid/loading, daftar kosong, serta status usulan.
Jalankan npm run build dan regression smoke test SSO, pengajuan, detail usulan, serta tautan e-panel.
Konfirmasi visual/fungsi e-panel Nue tidak berubah.
Asumsi
Cakupan mencakup publik dan portal pemohon; admin Nue sepenuhnya di luar redesign.
Tidak ada foto resmi yang disediakan, sehingga visual memakai motif abstrak CSS/SVG orisinal.
design.md lama diganti total agar tidak lagi membawa DNA Intel yang bertentangan dengan identitas JARSIPLUS.