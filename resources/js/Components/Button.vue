<script setup>
defineProps({
    variant: {
        type: String,
        default: 'primary' // primary, secondary, quiet, danger
    },
    type: {
        type: String,
        default: 'button'
    },
    disabled: Boolean,
    loading: Boolean
});
</script>

<template>
    <button
        :type="type"
        :disabled="disabled || loading"
        class="inline-flex items-center justify-center gap-2 font-bold text-xs rounded-xl px-4 py-2.5 transition focus-visible:outline-none disabled:opacity-50 disabled:cursor-not-allowed"
        :class="{
            'bg-[#0E8F79] text-white hover:bg-[#0A6E5D]': variant === 'primary',
            'bg-[#F0ECE1] text-[#14202B] border border-[#E5E1D8] hover:bg-[#E5E1D8]': variant === 'secondary',
            'bg-transparent text-[#3E4C57] hover:bg-[#F0ECE1]': variant === 'quiet',
            'bg-[#C0442E] text-white hover:bg-[#A03522]': variant === 'danger'
        }"
    >
        <span v-if="loading" class="animate-spin h-3.5 w-3.5 border-2 border-current border-t-transparent rounded-full" aria-hidden="true"></span>
        <slot />
    </button>
</template>
