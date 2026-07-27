<script setup>
defineProps({
    title: String,
    value: [String, Number],
    caption: String,
    highlight: Boolean
});
</script>

<template>
    <div class="card-paper p-6 flex flex-col justify-between" :class="{ 'border-l-4 border-l-[#0E8F79]': highlight }">
        <div>
            <div class="text-3xl sm:text-4xl font-extrabold text-[#14202B] tracking-tight tabular-nums mb-1">
                {{ value ?? 0 }}
            </div>
            <div class="text-sm font-bold text-[#14202B] mb-0.5">
                {{ title }}
            </div>
        </div>
        <p v-if="caption" class="text-xs text-[#71808A] mt-2 leading-relaxed">
            {{ caption }}
        </p>
    </div>
</template>
