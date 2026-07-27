<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const faqs = ref([
    {
        q: 'Siapa saja yang dapat mengajukan kerjasama melalui JARSIPLUS?',
        a: 'Pemerintah daerah lain, badan usaha milik negara/daerah (BUMN/BUMD), pihak swasta, perguruan tinggi, serta organisasi kemasyarakatan.'
    },
    {
        q: 'Berapa lama waktu proses verifikasi permohonan?',
        a: 'Proses verifikasi dokumen awal membutuhkan waktu maksimal 3 hari kerja setelah dokumen diunggah secara lengkap.'
    },
    {
        q: 'Apakah ada biaya dalam proses pengajuan kerjasama ini?',
        a: 'Pengajuan dan pelayanan adminisitrasi kerjasama pada JARSIPLUS 100% bebas biaya (gratis).'
    }
]);
</script>

<template>
    <Head title="Pertanyaan Umum (FAQ) - JARSIPLUS" />

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
                    <Link href="/statistik" class="text-slate-400 hover:text-white">Statistik</Link>
                    <Link href="/faq" class="text-blue-400 font-semibold">FAQ</Link>
                </nav>
            </div>
        </header>

        <main class="max-w-4xl mx-auto px-4 py-16">
            <h1 class="text-3xl font-bold mb-4">Pertanyaan Yang Sering Diajukan (FAQ)</h1>
            <p class="text-slate-400 mb-8">Informasi dan jawaban atas pertanyaan seputar layanan JARSIPLUS.</p>

            <div class="space-y-4">
                <div v-for="(item, index) in faqs" :key="index" class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <h3 class="text-lg font-semibold text-white mb-2">{{ item.q }}</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">{{ item.a }}</p>
                </div>
            </div>
        </main>
    </div>
</template>
