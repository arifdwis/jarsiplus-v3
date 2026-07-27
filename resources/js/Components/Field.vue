<script setup>
defineProps({
    label: String,
    hint: String,
    error: String,
    required: Boolean,
    id: String
});
</script>

<template>
    <div class="space-y-1.5">
        <label v-if="label" :for="id" class="block text-xs font-bold text-[#14202B] uppercase tracking-wider">
            {{ label }} <span v-if="required" class="text-[#C0442E]">*</span>
        </label>
        <p v-if="hint" class="text-[11px] text-[#71808A] mb-1">
            {{ hint }}
        </p>
        <slot />
        <p v-if="error" :id="`${id}-error`" class="text-xs font-semibold text-[#C0442E] mt-1" role="alert">
            {{ error }}
        </p>
    </div>
</template>
