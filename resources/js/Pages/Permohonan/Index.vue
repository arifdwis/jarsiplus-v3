<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
    permohonan: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <AppLayout title="Daftar Inovasi Saya">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-[#14202B]">Daftar Inovasi Daerah Saya</h1>
                    <p class="text-xs text-[#71808A]">Kelola dokumen dan pemenuhan indikator usulan inovasi daerah Anda.</p>
                </div>
                <Link href="/permohonan/create" class="btn-mahakam text-xs">
                    + Tambah Inovasi Baru
                </Link>
            </div>

            <!-- Empty State -->
            <div v-if="!permohonan || permohonan.length === 0" class="card-paper p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-[#E9F6F2] text-[#0E8F79] font-extrabold text-2xl flex items-center justify-center mx-auto mb-4">
                    ?
                </div>
                <h3 class="text-base font-bold text-[#14202B] mb-1">Belum Ada Inovasi Terdaftar</h3>
                <p class="text-xs text-[#71808A] mb-6">Anda belum mendaftarkan usulan inovasi daerah Kota Samarinda.</p>
                <Link href="/permohonan/create" class="btn-mahakam inline-block text-xs">
                    Ajukan Inovasi Sekarang
                </Link>
            </div>

            <!-- Data List -->
            <div v-else class="space-y-4">
                <Card v-for="item in permohonan" :key="item.id" class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <span class="text-xs font-bold text-[#0E8F79] uppercase tracking-wider block mb-1">
                            {{ item.kategori?.title || 'Inovasi Daerah' }}
                        </span>
                        <h3 class="text-base font-bold text-[#14202B] mb-1">{{ item.judul }}</h3>
                        <p class="text-xs text-[#71808A]">
                            Inovator: {{ item.instansi || '-' }} &bull; Tanggal: {{ item.created_at }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3 w-full md:w-auto justify-between">
                        <Badge variant="warning">Dalam Penilaian</Badge>
                        <Link :href="`/permohonan/${item.uuid}/detail`" class="px-4 py-2 rounded-xl bg-[#F0ECE1] text-[#14202B] text-xs font-bold hover:bg-[#E5E1D8] transition">
                            Lihat Indikator
                        </Link>
                    </div>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
