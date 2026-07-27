<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
    item: {
        type: Object,
        default: () => ({})
    }
});
</script>

<template>
    <AppLayout title="Detail Inovasi Daerah">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-16">
            <div class="mb-8">
                <Link href="/permohonan" class="text-xs font-semibold text-[#0E8F79] hover:underline mb-2 inline-block">
                    &larr; Kembali ke Daftar Inovasi
                </Link>
                <div class="flex items-center gap-3 mb-2">
                    <Badge variant="warning">{{ item.status_label || 'Dalam Verifikasi Indikator' }}</Badge>
                </div>
                <h1 class="text-2xl font-extrabold text-[#14202B]">{{ item.judul || 'Detail Usulan Inovasi' }}</h1>
                <p class="text-xs text-[#71808A] mt-1">Inovator: {{ item.instansi || '-' }} &bull; UUID: {{ item.uuid }}</p>
            </div>

            <Card class="space-y-6">
                <div>
                    <h3 class="text-xs font-bold text-[#14202B] uppercase tracking-wider mb-2">Rancang Bangun & Deskripsi</h3>
                    <p class="text-sm text-[#3E4C57] leading-relaxed">{{ item.deskripsi || 'Belum ada ringkasan deskripsi.' }}</p>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>
