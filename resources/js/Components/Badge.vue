<script setup>
defineProps({
    variant: {
        type: String,
        default: 'info' // success, warning, danger, info
    }
});
</script>

<template>
    <span
        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold"
        :class="{
            'bg-[#EAF8F1] text-[#1E9E6A] border border-[#1E9E6A]/20': variant === 'success',
            'bg-[#FEF6E9] text-[#C8871B] border border-[#C8871B]/20': variant === 'warning',
            'bg-[#FDF2F0] text-[#C0442E] border border-[#C0442E]/20': variant === 'danger',
            'bg-[#EEF5FA] text-[#2C6E9B] border border-[#2C6E9B]/20': variant === 'info'
        }"
    >
        <slot />
    </span>
</template>
