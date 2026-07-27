<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    item: {
        type: Object,
        default: () => ({})
    }
});
</script>

<template>
    <Head title="Detail Permohonan Kerjasama - JARSIPLUS" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
                <Link href="/permohonan" class="flex items-center gap-2 text-sm text-slate-400 hover:text-white">
                    <i class="bi bi-arrow-left"></i> Kembali
                </Link>
            </div>
        </header>

        <main class="max-w-4xl mx-auto px-4 py-12">
            <div class="p-8 rounded-2xl bg-slate-900 border border-slate-800 mb-8">
                <div class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-4">
                    Status: {{ item.status_label || 'Dalam Verifikasi' }}
                </div>
                <h1 class="text-2xl font-bold mb-2">{{ item.judul || 'Permohonan Kerjasama' }}</h1>
                <p class="text-sm text-slate-400 mb-6">Instansi: {{ item.instansi || '-' }} &bull; Kode UUID: {{ item.uuid }}</p>

                <div class="border-t border-slate-800 pt-6">
                    <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-2">Ringkasan Deskripsi</h3>
                    <p class="text-slate-300 text-sm leading-relaxed">{{ item.deskripsi || 'Belum ada deskripsi tambahan.' }}</p>
                </div>
            </div>
        </main>
    </div>
</template>
