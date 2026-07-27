<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    judul: '',
    instansi: '',
    deskripsi: '',
    kategori_id: ''
});

const submit = () => {
    form.post('/permohonan');
};
</script>

<template>
    <Head title="Pengajuan Kerjasama Baru - JARSIPLUS" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
                <Link href="/permohonan" class="flex items-center gap-2 text-sm text-slate-400 hover:text-white">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Permohonan
                </Link>
            </div>
        </header>

        <main class="max-w-3xl mx-auto px-4 py-12">
            <h1 class="text-2xl font-bold mb-2">Formulir Pengajuan Naskah Kerjasama</h1>
            <p class="text-sm text-slate-400 mb-8">Lengkapi informasi dan data dasar pengajuan kerjasama.</p>

            <form @submit.prevent="submit" class="p-8 rounded-2xl bg-slate-900 border border-slate-800 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Judul Permohonan Kerjasama</label>
                    <input v-model="form.judul" type="text" placeholder="Masukkan judul naskah kerjasama" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 text-sm" required />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Nama Instansi / Mitra Pemohon</label>
                    <input v-model="form.instansi" type="text" placeholder="Nama organisasi / instansi" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 text-sm" required />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Ringkasan Maksud & Tujuan</label>
                    <textarea v-model="form.deskripsi" rows="4" placeholder="Jelaskan secara singkat ruang lingkup kerjasama..." class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 text-sm" required></textarea>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <Link href="/permohonan" class="px-6 py-3 rounded-xl bg-slate-800 text-sm font-semibold text-slate-300 hover:bg-slate-700 transition">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition disabled:opacity-50">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </main>
    </div>
</template>
