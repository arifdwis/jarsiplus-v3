<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';

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
    <AppLayout title="Pengajuan Inovasi Baru">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 py-16">
            <div class="mb-8">
                <Link href="/permohonan" class="text-xs font-semibold text-[#0E8F79] hover:underline mb-2 inline-block">
                    &larr; Kembali ke Daftar Inovasi
                </Link>
                <h1 class="text-2xl font-extrabold text-[#14202B]">Formulir Pengajuan Inovasi Daerah</h1>
                <p class="text-xs text-[#71808A]">Lengkapi informasi dasar usulan inovasi daerah Kota Samarinda.</p>
            </div>

            <Card>
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-[#14202B] uppercase tracking-wider mb-2">Nama Inovasi Daerah</label>
                        <input
                            v-model="form.judul"
                            type="text"
                            placeholder="Contoh: Aplikasi Sistem Pelayanan Terpadu..."
                            class="w-full px-4 py-3 rounded-xl bg-[#F7F5F0] border border-[#E5E1D8] text-[#14202B] text-sm focus:outline-none focus:border-[#0E8F79]"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#14202B] uppercase tracking-wider mb-2">Inovator / Perangkat Daerah (OPD)</label>
                        <input
                            v-model="form.instansi"
                            type="text"
                            placeholder="Dinas / UPTD / Kelompok Inovator"
                            class="w-full px-4 py-3 rounded-xl bg-[#F7F5F0] border border-[#E5E1D8] text-[#14202B] text-sm focus:outline-none focus:border-[#0E8F79]"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#14202B] uppercase tracking-wider mb-2">Rancang Bangun & Ringkasan Inovasi</label>
                        <textarea
                            v-model="form.deskripsi"
                            rows="4"
                            placeholder="Jelaskan secara ringkas latar belakang dan keunggulan inovasi..."
                            class="w-full px-4 py-3 rounded-xl bg-[#F7F5F0] border border-[#E5E1D8] text-[#14202B] text-sm focus:outline-none focus:border-[#0E8F79]"
                            required
                        ></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-[#E5E1D8]">
                        <Link href="/permohonan" class="px-5 py-2.5 rounded-xl bg-[#F0ECE1] text-xs font-bold text-[#3E4C57] hover:bg-[#E5E1D8] transition">
                            Batal
                        </Link>
                        <button type="submit" :disabled="form.processing" class="btn-mahakam text-xs disabled:opacity-50">
                            Kirim Usulan Inovasi
                        </button>
                    </div>
                </form>
            </Card>
        </div>
    </AppLayout>
</template>
