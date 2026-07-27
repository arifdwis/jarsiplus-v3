<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    proses: Number,
    setuju: Number,
    tolak: Number,
    selesai: Number,
    permohonan: Number,
    cpemohon: Number,
    permohonanPerHari: Object,
    permohonanPerBulan: Object
});
</script>

<template>
    <Head title="Statistik Kerjasama Daerah - JARSIPLUS" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
                <Link href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold text-white">J</div>
                    <span class="text-xl font-bold">JARSIPLUS</span>
                </Link>
                <nav class="flex gap-6 text-sm font-medium">
                    <Link href="/" class="text-slate-400 hover:text-white">Beranda</Link>
                    <Link href="/informasi" class="text-slate-400 hover:text-white">Informasi</Link>
                    <Link href="/statistik" class="text-blue-400 font-semibold">Statistik</Link>
                    <Link href="/faq" class="text-slate-400 hover:text-white">FAQ</Link>
                </nav>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 py-16">
            <h1 class="text-3xl font-bold mb-2">Statistik Kerjasama Daerah</h1>
            <p class="text-slate-400 mb-8">Ringkasan statistik kuantitatif permohonan kerjasama Kota Samarinda.</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <div class="text-2xl font-bold text-blue-400 mb-1">{{ permohonan || 0 }}</div>
                    <div class="text-xs text-slate-400">Total Permohonan</div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <div class="text-2xl font-bold text-yellow-400 mb-1">{{ proses || 0 }}</div>
                    <div class="text-xs text-slate-400">Dalam Proses</div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <div class="text-2xl font-bold text-emerald-400 mb-1">{{ setuju || 0 }}</div>
                    <div class="text-xs text-slate-400">Disetujui</div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <div class="text-2xl font-bold text-purple-400 mb-1">{{ cpemohon || 0 }}</div>
                    <div class="text-xs text-slate-400">Mitra/Pemohon</div>
                </div>
            </div>
        </main>
    </div>
</template>
