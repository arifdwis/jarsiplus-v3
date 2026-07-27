<script setup>
import { ref } from 'vue';
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';

const faqs = ref([
    {
        q: 'Siapa saja yang dapat mengajukan usulan Inovasi Daerah di JARSIPLUS?',
        a: 'Perangkat Daerah (OPD), UPTD, ASN, serta masyarakat/kelompok inovator di wilayah Kota Samarinda.'
    },
    {
        q: 'Bagaimana proses penilaian dan pengukuran Indeks Inovasi Daerah dilakukan?',
        a: 'Penilaian dilakukan berdasarkan pengunggahan data bukti fisik dari 20+ indikator inovasi daerah sesuai regulasi Kementerian Dalam Negeri.'
    },
    {
        q: 'Apakah pengajuan inovasi daerah dipungut biaya?',
        a: 'Seluruh proses pengajuan, pendampingan, dan verifikasi inovasi daerah di JARSIPLUS 100% GRATIS.'
    }
]);
</script>

<template>
    <AppLayout title="Pertanyaan Umum (FAQ)">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-16">
            <div class="mb-10">
                <div class="inline-flex items-center px-3 py-1 rounded-md bg-[#E9F6F2] text-[#0E8F79] text-xs font-bold uppercase tracking-wider mb-3">
                    Pertanyaan Populer
                </div>
                <h1 class="text-3xl font-extrabold text-[#14202B] mb-2">Pertanyaan Yang Sering Diajukan</h1>
                <p class="text-sm text-[#71808A]">Jawaban lengkap seputar tata cara pendaftaran, indikator, dan verifikasi inovasi daerah.</p>
            </div>

            <div class="space-y-4">
                <Card v-for="(item, index) in faqs" :key="index">
                    <h3 class="text-base font-bold text-[#14202B] mb-2">{{ item.q }}</h3>
                    <p class="text-sm text-[#3E4C57] leading-relaxed">{{ item.a }}</p>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
