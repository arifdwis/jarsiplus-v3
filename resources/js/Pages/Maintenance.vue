<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
</script>

<template>
    <AppLayout title="Pemeliharaan Sistem">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 py-24 text-center">
            <Card class="p-10">
                <div class="w-16 h-16 rounded-2xl bg-[#FEF3D6] text-[#C8871B] font-extrabold text-2xl flex items-center justify-center mx-auto mb-6">
                    !
                </div>
                <h1 class="text-2xl font-extrabold text-[#14202B] mb-3">Sistem Sedang Dalam Pemeliharaan</h1>
                <p class="text-sm text-[#3E4C57] leading-relaxed mb-6">
                    Platform JARSIPLUS sedang menjalani peningkatan performa berkala. Layanan akan kembali normal dalam waktu dekat.
                </p>
                <a href="/" class="btn-mahakam inline-block text-xs">
                    Kembali ke Beranda
                </a>
            </Card>
        </div>
    </AppLayout>
</template>
