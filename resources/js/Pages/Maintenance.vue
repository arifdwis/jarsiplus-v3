<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Pemeliharaan Sistem - JARSIPLUS" />

    <div class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4">
        <div class="max-w-md text-center">
            <div class="w-16 h-16 rounded-2xl bg-blue-600/10 border border-blue-500/20 text-blue-400 flex items-center justify-center text-3xl mx-auto mb-6">
                <i class="bi bi-tools"></i>
            </div>
            <h1 class="text-2xl font-bold mb-2">Pemeliharaan Sistem</h1>
            <p class="text-slate-400 text-sm mb-8 leading-relaxed">
                Layanan JARSIPLUS sedang dalam peningkatan sistem secara berkala. Mohon kembali beberapa saat lagi.
            </p>
            <Link href="/" class="px-6 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-500 transition inline-block">
                Kembali ke Beranda
            </Link>
        </div>
    </div>
</template>
