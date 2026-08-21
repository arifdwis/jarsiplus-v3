<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/AppLayout.vue';
import StatTile from '@/Components/StatTile.vue';
import Card from '@/Components/Card.vue';

defineProps({
    permohonanCount: {
        type: Number,
        default: 0
    },
    prosesCount: {
        type: Number,
        default: 0
    },
    setujuCount: {
        type: Number,
        default: 0
    }
});
</script>

<template>
    <AppLayout title="Beranda">
        <!-- Hero Section -->
        <section class="pt-16 pb-20 md:pt-24 md:pb-28">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-[#E9F6F2] border border-[#0E8F79]/20 text-[#0E8F79] text-xs font-extrabold uppercase tracking-wider mb-6">
                        Jaringan Aplikasi Inovasi Plus Kota Samarinda
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[#14202B] tracking-tight leading-tight mb-6">
                        Platform Pengajuan & Penilaian Inovasi Daerah
                    </h1>
                    <p class="text-base sm:text-lg text-[#3E4C57] mb-8 leading-relaxed">
                        JARSIPLUS memfasilitasi pendokumentasian, pemenuhan indikator bukti fisik, verifikasi, serta pengukuran Indeks Inovasi Daerah Pemerintah Kota Samarinda secara akuntabel dan transparan.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <Link href="/permohonan" class="btn-mahakam flex items-center gap-2 text-sm">
                            Ajukan Inovasi Daerah
                        </Link>
                        <Link href="/informasi" class="px-5 py-2.5 rounded-xl bg-white border border-[#E5E1D8] text-[#14202B] font-bold text-sm hover:bg-[#F0ECE1] transition flex items-center gap-2">
                            Alur & Indikator Penilaian
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Counter Section -->
        <section class="py-12 bg-white border-y border-[#E5E1D8]">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <StatTile
                        title="Total Inovasi Terdaftar"
                        :value="permohonanCount"
                        caption="Usulan inovasi Perangkat Daerah & masyarakat"
                        highlight
                    />
                    <StatTile
                        title="Sedang Dalam Penilaian"
                        :value="prosesCount"
                        caption="Tahap verifikasi & pemenuhan bukti fisik"
                    />
                    <StatTile
                        title="Inovasi Tervalidasi"
                        :value="setujuCount"
                        caption="Lolos verifikasi & terindeks secara resmi"
                    />
                </div>
            </div>
        </section>

        <!-- 3-Step Flow Section -->
        <section class="py-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#14202B] mb-3">Alur Pengajuan & Penilaian</h2>
                    <p class="text-sm text-[#71808A]">Proses berjenjang yang transparan untuk mengukur indeks inovasi daerah.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Card class="relative">
                        <div class="w-10 h-10 rounded-xl bg-[#E9F6F2] text-[#0E8F79] font-extrabold text-base flex items-center justify-center mb-4">1</div>
                        <h3 class="text-lg font-bold text-[#14202B] mb-2">1. Input Profil Inovasi</h3>
                        <p class="text-xs text-[#3E4C57] leading-relaxed">
                            Daftarkan rancang bangun inovasi, identitas inovator, serta kategori inovasi melalui Portal Pemohon.
                        </p>
                    </Card>

                    <Card class="relative">
                        <div class="w-10 h-10 rounded-xl bg-[#FEF3D6] text-[#C8871B] font-extrabold text-base flex items-center justify-center mb-4">2</div>
                        <h3 class="text-lg font-bold text-[#14202B] mb-2">2. Unggah Bukti Indikator</h3>
                        <p class="text-xs text-[#3E4C57] leading-relaxed">
                            Lengkapi dokumen dan bukti fisik pendukung dari 20+ indikator inovasi daerah sesuai petunjuk teknis.
                        </p>
                    </Card>

                    <Card class="relative">
                        <div class="w-10 h-10 rounded-xl bg-[#EEF5FA] text-[#2C6E9B] font-extrabold text-base flex items-center justify-center mb-4">3</div>
                        <h3 class="text-lg font-bold text-[#14202B] mb-2">3. Verifikasi & Pemetaan</h3>
                        <p class="text-xs text-[#3E4C57] leading-relaxed">
                            Tim penilai melakukan verifikasi berkas dan menetapkan skor kematangan inovasi daerah.
                        </p>
                    </Card>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
