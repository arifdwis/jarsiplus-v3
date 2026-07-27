<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
</script>

<template>
    <AppLayout title="Informasi & Pedoman">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-16">
            <div class="mb-10">
                <div class="inline-flex items-center px-3 py-1 rounded-md bg-[#E9F6F2] text-[#0E8F79] text-xs font-bold uppercase tracking-wider mb-3">
                    Panduan & Regulasi
                </div>
                <h1 class="text-3xl font-extrabold text-[#14202B] mb-3">Informasi & Pedoman Inovasi Daerah</h1>
                <p class="text-sm text-[#71808A]">Tata cara pengajuan, kriteria penilaian, dan penyampaian bukti fisik inovasi daerah Kota Samarinda.</p>
            </div>

            <div class="space-y-6">
                <Card>
                    <h2 class="text-lg font-bold text-[#0E8F79] mb-2">1. Ketentuan Pengajuan Inovasi</h2>
                    <p class="text-sm text-[#3E4C57] leading-relaxed">
                        Setiap Perangkat Daerah (OPD), UPTD, ASN, maupun kelompok masyarakat di Kota Samarinda berhak mengajukan usulan inovasi daerah. Inovasi yang didaftarkan wajib memiliki kemanfaatan nyata, dapat direplikasi, serta memiliki kepemilikan yang sah.
                    </p>
                </Card>

                <Card>
                    <h2 class="text-lg font-bold text-[#14202B] mb-2">2. Pemenuhan Indikator Bukti Fisik</h2>
                    <p class="text-sm text-[#3E4C57] leading-relaxed">
                        Verifikasi dilakukan berdasarkan 20+ indikator penilaian (seperti Regulasi Inovasi, Ketersediaan SDM, Anggaran, Profil Bisnis, Foto/Video Penerapan, dan Kemanfaatan Publik). Dokumen bukti fisik wajib diunggah dalam format PDF/JPG melalui portal.
                    </p>
                </Card>

                <Card>
                    <h2 class="text-lg font-bold text-[#14202B] mb-2">3. Tahapan Validasi & Indeks</h2>
                    <p class="text-sm text-[#3E4C57] leading-relaxed">
                        Tahapan verifikasi meliputi: Pendaftaran Usulan → Verifikasi Administratif oleh Admin → Penilaian Indikator oleh Tim Penilai → Penetapan Skor Indeks Kematangan Inovasi Daerah Kota Samarinda.
                    </p>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
