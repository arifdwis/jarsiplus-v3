<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import StatTile from '@/Components/StatTile.vue';

defineProps({
    proses: Number,
    setuju: Number,
    tolak: Number,
    selesai: Number,
    permohonan: Number,
    cpemohon: Number
});
</script>

<template>
    <AppLayout title="Statistik Inovasi">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
            <div class="mb-10">
                <div class="inline-flex items-center px-3 py-1 rounded-md bg-[#E9F6F2] text-[#0E8F79] text-xs font-bold uppercase tracking-wider mb-3">
                    Data Kuantitatif
                </div>
                <h1 class="text-3xl font-extrabold text-[#14202B] mb-2">Statistik Inovasi Daerah</h1>
                <p class="text-sm text-[#71808A]">Rekapitulasi data usulan, status verifikasi, dan jumlah inovator terdaftar Kota Samarinda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <StatTile
                    title="Total Usulan Inovasi"
                    :value="permohonan || 0"
                    caption="Seluruh usulan yang masuk ke sistem"
                    highlight
                />
                <StatTile
                    title="Dalam Tahap Penilaian"
                    :value="proses || 0"
                    caption="Proses verifikasi & kelengkapan indikator"
                />
                <StatTile
                    title="Inovasi Tervalidasi"
                    :value="setuju || 0"
                    caption="Disetujui & masuk dalam indeks"
                />
                <StatTile
                    title="Jumlah Inovator / OPD"
                    :value="cpemohon || 0"
                    caption="Perangkat daerah & unit pengaju"
                />
            </div>
        </div>
    </AppLayout>
</template>
