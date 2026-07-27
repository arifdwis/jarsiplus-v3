<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    permohonan: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <Head title="Daftar Permohonan Saya - JARSIPLUS" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <!-- Header -->
        <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
                <Link href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold text-white">J</div>
                    <div>
                        <span class="text-lg font-bold block leading-none">JARSIPLUS</span>
                        <span class="text-xs text-slate-400">Portal Pemohon</span>
                    </div>
                </Link>

                <div class="flex items-center gap-4">
                    <Link href="/permohonan/create" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold transition flex items-center gap-2">
                        <i class="bi bi-plus-lg"></i> Buat Permohonan Baru
                    </Link>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 py-12">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold">Daftar Pengajuan Kerjasama</h1>
                    <p class="text-sm text-slate-400">Kelola dan pantau status naskah kerjasama daerah yang Anda ajukan.</p>
                </div>
            </div>

            <!-- Empty State / Data List -->
            <div v-if="!permohonan || permohonan.length === 0" class="p-12 rounded-2xl bg-slate-900 border border-slate-800 text-center">
                <div class="w-16 h-16 rounded-2xl bg-slate-800 text-slate-500 flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <h3 class="text-lg font-semibold mb-1">Belum Ada Permohonan</h3>
                <p class="text-sm text-slate-400 mb-6">Anda belum pernah membuat atau mengajukan permohonan naskah kerjasama.</p>
                <Link href="/permohonan/create" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-500 transition inline-block">
                    Mulai Ajukan Kerjasama
                </Link>
            </div>

            <div v-else class="space-y-4">
                <div v-for="item in permohonan" :key="item.id" class="p-6 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="text-xs text-blue-400 font-semibold uppercase tracking-wider mb-1">{{ item.kategori?.title || 'Kerjasama Daerah' }}</div>
                        <h3 class="text-lg font-bold text-white mb-1">{{ item.judul }}</h3>
                        <p class="text-sm text-slate-400 line-clamp-1">{{ item.instansi }} &bull; Diajukan: {{ item.created_at }}</p>
                    </div>
                    <div class="flex items-center gap-3 w-full md:w-auto justify-between">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                            Dalam Proses
                        </span>
                        <Link :href="`/permohonan/${item.uuid}/detail`" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-sm font-semibold transition">
                            Lihat Detail
                        </Link>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
