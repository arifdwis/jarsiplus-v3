<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

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

const isMenuOpen = ref(false);
</script>

<template>
    <Head title="Sistem Informasi Jaringan Kerjasama Pemerintah Kota Samarinda" />

    <div class="min-h-screen bg-slate-950 text-slate-100 selection:bg-blue-600 selection:text-white">
        <!-- Navigation Bar -->
        <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i class="bi bi-diagram-3-fill text-xl text-white"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">JARSIPLUS</span>
                        <span class="text-xs block font-medium text-blue-400">Kota Samarinda</span>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <Link href="/" class="text-blue-400 font-semibold">Beranda</Link>
                    <Link href="/informasi" class="text-slate-400 hover:text-white transition">Informasi</Link>
                    <Link href="/statistik" class="text-slate-400 hover:text-white transition">Statistik</Link>
                    <Link href="/faq" class="text-slate-400 hover:text-white transition">FAQ</Link>
                </nav>

                <div class="hidden md:flex items-center gap-4">
                    <a href="/jarsiplus/permohonan" class="px-5 py-2.5 rounded-xl bg-slate-900 border border-slate-700 hover:border-slate-600 text-sm font-semibold transition">
                        E-Panel Admin
                    </a>
                    <Link href="/permohonan" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition">
                        Portal Pemohon
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="isMenuOpen = !isMenuOpen" class="md:hidden p-2 text-slate-400 hover:text-white">
                    <i class="bi" :class="isMenuOpen ? 'bi-x-lg' : 'bi-list'"></i>
                </button>
            </div>

            <!-- Mobile Nav -->
            <div v-if="isMenuOpen" class="md:hidden px-4 pb-6 pt-2 space-y-3 bg-slate-950 border-b border-slate-800">
                <Link href="/" class="block py-2 text-blue-400 font-medium">Beranda</Link>
                <Link href="/informasi" class="block py-2 text-slate-300">Informasi</Link>
                <Link href="/statistik" class="block py-2 text-slate-300">Statistik</Link>
                <Link href="/faq" class="block py-2 text-slate-300">FAQ</Link>
                <div class="pt-4 flex flex-col gap-2">
                    <a href="/jarsiplus/permohonan" class="text-center py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm font-semibold">E-Panel Admin</a>
                    <Link href="/permohonan" class="text-center py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold">Portal Pemohon</Link>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative py-24 md:py-32 overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-semibold uppercase tracking-wider mb-6">
                        <i class="bi bi-shield-check"></i> Platform Resmi Kerjasama Daerah 2026
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                        Transparansi & Efisiensi Kerjasama <span class="bg-gradient-to-r from-blue-400 via-indigo-300 to-purple-400 bg-clip-text text-transparent">Pemerintah Kota Samarinda</span>
                    </h1>
                    <p class="text-lg text-slate-400 mb-8 leading-relaxed">
                        JARSIPLUS memfasilitasi pengajuan, verifikasi, pembahasan, serta pemantauan naskah kesepakatan dan perjanjian kerjasama secara digital dan akuntabel.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <Link href="/permohonan" class="px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-semibold shadow-xl shadow-blue-600/30 transition flex items-center gap-2">
                            <i class="bi bi-file-earmark-plus"></i> Ajukan Kerjasama Baru
                        </Link>
                        <Link href="/informasi" class="px-8 py-4 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-200 font-semibold transition flex items-center gap-2">
                            <i class="bi bi-info-circle"></i> Alur & Ketentuan
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Counter -->
        <section class="py-16 bg-slate-900/50 border-y border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-3 gap-8">
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <div class="text-3xl sm:text-4xl font-extrabold text-blue-400 mb-2">{{ permohonanCount || '120+' }}</div>
                    <div class="text-sm font-semibold text-slate-300">Total Kerjasama Terdaftar</div>
                    <p class="text-xs text-slate-500 mt-1">Kesepakatan bersama & perjanjian kerja</p>
                </div>
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <div class="text-3xl sm:text-4xl font-extrabold text-indigo-400 mb-2">{{ prosesCount || '45' }}</div>
                    <div class="text-sm font-semibold text-slate-300">Sedang Dalam Pembahasan</div>
                    <p class="text-xs text-slate-500 mt-1">Proses verifikasi & validasi berkas</p>
                </div>
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800">
                    <div class="text-3xl sm:text-4xl font-extrabold text-emerald-400 mb-2">{{ setujuCount || '75+' }}</div>
                    <div class="text-sm font-semibold text-slate-300">Telah Disetujui & Aktif</div>
                    <p class="text-xs text-slate-500 mt-1">Berjalan & memberikan dampak publik</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-950 border-t border-slate-800 py-12 text-sm text-slate-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <div class="font-bold text-slate-300 text-base mb-1">Pemerintah Kota Samarinda</div>
                    <p>&copy; 2026 JARSIPLUS. Bagian Kerjasama Sekretariat Daerah Kota Samarinda.</p>
                </div>
                <div class="flex gap-6">
                    <Link href="/informasi" class="hover:text-slate-300 transition">Informasi</Link>
                    <Link href="/statistik" class="hover:text-slate-300 transition">Statistik</Link>
                    <Link href="/faq" class="hover:text-slate-300 transition">FAQ</Link>
                </div>
            </div>
        </footer>
    </div>
</template>
