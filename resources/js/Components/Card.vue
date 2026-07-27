<script setup>
defineProps({
    variant: {
        type: String,
        default: 'default' // default, quiet, interactive
    }
});
</script>

<template>
    <div
        class="card-paper p-6"
        :class="{
            'bg-white border-[#E5E1D8]': variant === 'default',
            'bg-[#F7F5F0] border-transparent shadow-none': variant === 'quiet',
            'bg-white border-[#E5E1D8] cursor-pointer hover:border-[#0E8F79] hover:shadow-lg': variant === 'interactive'
        }"
    >
        <slot />
    </div>
</template>
