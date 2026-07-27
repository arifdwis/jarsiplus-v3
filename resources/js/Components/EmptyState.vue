<script setup>
defineProps({
    title: {
        type: String,
        default: 'Belum Ada Data'
    },
    description: String
});
</script>

<template>
    <div class="card-paper p-10 text-center flex flex-col items-center justify-center">
        <div class="w-12 h-12 rounded-xl bg-[#E9F6F2] text-[#0E8F79] font-extrabold text-xl flex items-center justify-center mb-3">
            —
        </div>
        <h3 class="text-base font-bold text-[#14202B] mb-1">{{ title }}</h3>
        <p v-if="description" class="text-xs text-[#71808A] max-w-md mb-4 leading-relaxed">
            {{ description }}
        </p>
        <slot />
    </div>
</template>
