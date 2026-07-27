<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
import Field from '@/Components/Field.vue';
import Button from '@/Components/Button.vue';

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
                    <Field
                        id="judul"
                        label="Nama Inovasi Daerah"
                        hint="Contoh: Aplikasi Sistem Pelayanan Terpadu..."
                        :error="form.errors.judul"
                        required
                    >
                        <input
                            id="judul"
                            v-model="form.judul"
                            type="text"
                            placeholder="Ketik nama inovasi..."
                            class="w-full px-4 py-3 rounded-xl bg-[#F7F5F0] border border-[#E5E1D8] text-[#14202B] text-sm focus:outline-none focus:border-[#0E8F79]"
                            required
                        />
                    </Field>

                    <Field
                        id="instansi"
                        label="Inovator / Perangkat Daerah (OPD)"
                        hint="Dinas / UPTD / Kelompok Inovator"
                        :error="form.errors.instansi"
                        required
                    >
                        <input
                            id="instansi"
                            v-model="form.instansi"
                            type="text"
                            placeholder="Nama perangkat daerah / unit..."
                            class="w-full px-4 py-3 rounded-xl bg-[#F7F5F0] border border-[#E5E1D8] text-[#14202B] text-sm focus:outline-none focus:border-[#0E8F79]"
                            required
                        />
                    </Field>

                    <Field
                        id="deskripsi"
                        label="Rancang Bangun & Ringkasan Inovasi"
                        hint="Jelaskan secara ringkas latar belakang dan keunggulan inovasi..."
                        :error="form.errors.deskripsi"
                        required
                    >
                        <textarea
                            id="deskripsi"
                            v-model="form.deskripsi"
                            rows="4"
                            placeholder="Ringkasan inovasi daerah..."
                            class="w-full px-4 py-3 rounded-xl bg-[#F7F5F0] border border-[#E5E1D8] text-[#14202B] text-sm focus:outline-none focus:border-[#0E8F79]"
                            required
                        ></textarea>
                    </Field>

                    <div class="pt-4 flex justify-end gap-3 border-t border-[#E5E1D8]">
                        <Link href="/permohonan">
                            <Button variant="secondary">Batal</Button>
                        </Link>
                        <Button type="submit" variant="primary" :loading="form.processing">
                            Kirim Usulan Inovasi
                        </Button>
                    </div>
                </form>
            </Card>
        </div>
    </AppLayout>
</template>
