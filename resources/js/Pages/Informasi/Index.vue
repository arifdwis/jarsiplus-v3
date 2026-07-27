<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Informasi & Ketentuan Kerjasama - JARSIPLUS" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <!-- Header -->
        <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
                <Link href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold text-white">J</div>
                    <span class="text-xl font-bold">JARSIPLUS</span>
                </Link>
                <nav class="flex gap-6 text-sm font-medium">
                    <Link href="/" class="text-slate-400 hover:text-white">Beranda</Link>
                    <Link href="/informasi" class="text-blue-400 font-semibold">Informasi</Link>
                    <Link href="/statistik" class="text-slate-400 hover:text-white">Statistik</Link>
                    <Link href="/faq" class="text-slate-400 hover:text-white">FAQ</Link>
                </nav>
            </div>
        </header>

        <main class="max-w-4xl mx-auto px-4 py-16">
            <h1 class="text-3xl font-bold mb-4">Informasi & Pedoman Pengajuan Kerjasama</h1>
            <p class="text-slate-400 mb-8">Panduan lengkap tata cara pengajuan kerjasama dengan Pemerintah Kota Samarinda.</p>

            <div class="space-y-6">
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <h2 class="text-xl font-semibold text-blue-400 mb-2">1. Persyaratan Administratif</h2>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Pemohon wajib menyertakan profil lembaga/badan usaha, surat permohonan resmi kepada Wali Kota Samarinda, draft naskah kesepakatan/perjanjian, serta dokumen legalitas instansi.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <h2 class="text-xl font-semibold text-indigo-400 mb-2">2. Tahapan Alur Pembahasan</h2>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Verifikasi Berkas → Verifikasi Tim Anggaran & Legalitas → Rapat Pembahasan Bersama → Penandatanganan Kesepakatan Bersama / Perjanjian Kerjasama.
                    </p>
                </div>
            </div>
        </main>
    </div>
</template>
