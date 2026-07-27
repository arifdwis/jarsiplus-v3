<script setup>
import { ref } from 'vue';

defineProps({
    items: {
        type: Array,
        default: () => []
    }
});

const openIndex = ref(0); // Default first item open

const toggle = (index) => {
    openIndex.value = openIndex.value === index ? -1 : index;
};
</script>

<template>
    <div class="space-y-3">
        <div
            v-for="(item, index) in items"
            :key="index"
            class="card-paper overflow-hidden"
        >
            <button
                type="button"
                @click="toggle(index)"
                :aria-expanded="openIndex === index"
                :aria-controls="`accordion-panel-${index}`"
                :id="`accordion-header-${index}`"
                class="w-full px-6 py-4 flex items-center justify-between text-left focus-visible:outline-none"
            >
                <span class="text-sm font-bold text-[#14202B]">{{ item.title || item.q }}</span>
                <span class="text-[#0E8F79] font-bold text-lg leading-none transition-transform duration-200" :class="{ 'rotate-180': openIndex === index }">
                    &darr;
                </span>
            </button>
            <div
                v-show="openIndex === index"
                :id="`accordion-panel-${index}`"
                :aria-labelledby="`accordion-header-${index}`"
                class="px-6 pb-5 pt-1 text-sm text-[#3E4C57] leading-relaxed border-t border-[#E5E1D8]/50"
            >
                {{ item.content || item.a }}
            </div>
        </div>
    </div>
</template>
