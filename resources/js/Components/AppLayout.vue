<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    title: String
});

const isMobileMenuOpen = ref(false);
</script>

<template>
    <div>
        <Head :title="title ? `${title} - JARSIPLUS Kota Samarinda` : 'JARSIPLUS - Jaringan Aplikasi Inovasi Plus Kota Samarinda'" />

        <div class="min-h-screen bg-[#F7F5F0] text-[#3E4C57] flex flex-col font-sans">
            <!-- Header Navigation -->
            <header class="sticky top-4 z-50 max-w-6xl mx-auto w-full px-4 sm:px-6">
                <div class="header-pill rounded-2xl px-6 h-16 flex items-center justify-between">
                    <!-- Brand Logo -->
                    <Link href="/" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-[#0E8F79] text-white flex items-center justify-center font-bold text-lg shadow-sm group-hover:bg-[#0A6E5D] transition">
                            J
                        </div>
                        <div>
                            <span class="text-base font-extrabold tracking-tight text-[#14202B] block leading-none">JARSIPLUS</span>
                            <span class="text-[10px] font-semibold text-[#0E8F79]">Inovasi Daerah Kota Samarinda</span>
                        </div>
                    </Link>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center gap-8 text-sm font-semibold">
                        <Link href="/" class="text-[#14202B] hover:text-[#0E8F79] transition">Beranda</Link>
                        <Link href="/informasi" class="text-[#3E4C57] hover:text-[#0E8F79] transition">Informasi</Link>
                        <Link href="/statistik" class="text-[#3E4C57] hover:text-[#0E8F79] transition">Statistik</Link>
                        <Link href="/faq" class="text-[#3E4C57] hover:text-[#0E8F79] transition">FAQ</Link>
                    </nav>

                    <!-- Desktop Action Buttons -->
                    <div class="hidden md:flex items-center gap-3">
                        <a href="/jarsiplus/permohonan" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-[#3E4C57] bg-[#E5E1D8]/50 hover:bg-[#E5E1D8] transition">
                            E-Panel Admin
                        </a>
                        <Link href="/permohonan" class="btn-mahakam text-xs">
                            Portal Pemohon
                        </Link>
                    </div>

                    <!-- Mobile Hamburger -->
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden p-2 text-[#14202B] focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu Dropdown -->
                <div v-if="isMobileMenuOpen" class="md:hidden mt-2 p-5 rounded-2xl bg-white border border-[#E5E1D8] shadow-lg space-y-3 text-sm font-semibold">
                    <Link href="/" class="block text-[#14202B]">Beranda</Link>
                    <Link href="/informasi" class="block text-[#3E4C57]">Informasi</Link>
                    <Link href="/statistik" class="block text-[#3E4C57]">Statistik</Link>
                    <Link href="/faq" class="block text-[#3E4C57]">FAQ</Link>
                    <div class="pt-3 border-t border-[#E5E1D8] flex flex-col gap-2">
                        <a href="/jarsiplus/permohonan" class="text-center py-2 rounded-xl bg-[#E5E1D8]/50 text-xs font-semibold text-[#14202B]">E-Panel Admin</a>
                        <Link href="/permohonan" class="text-center py-2 rounded-xl bg-[#0E8F79] text-white font-bold text-xs">Portal Pemohon</Link>
                    </div>
                </div>
            </header>

            <!-- Main Content Shell -->
            <main class="flex-grow">
                <slot />
            </main>

            <!-- Editorial Footer -->
            <footer class="bg-white border-t border-[#E5E1D8] mt-20 py-12 text-sm text-[#71808A]">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-[#14202B] text-base">Pemerintah Kota Samarinda</span>
                        </div>
                        <p class="text-xs text-[#71808A]">JARSIPLUS — Jaringan Aplikasi Inovasi Plus Kota Samarinda &copy; 2026</p>
                    </div>
                    <div class="flex items-center gap-6 text-xs font-semibold text-[#3E4C57]">
                        <Link href="/informasi" class="hover:text-[#0E8F79] transition">Informasi</Link>
                        <Link href="/statistik" class="hover:text-[#0E8F79] transition">Statistik</Link>
                        <Link href="/faq" class="hover:text-[#0E8F79] transition">FAQ</Link>
                        <a href="/jarsiplus/permohonan" class="hover:text-[#0E8F79] transition">E-Panel Admin</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
