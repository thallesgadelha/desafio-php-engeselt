<template>
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <div v-for="(step, index) in steps" :key="index" class="flex items-center">
            <div :class="[
                'w-5 h-5 rounded-full border-2',
                index <= currentIndex ? 'bg-blue-600 border-blue-600' : 'bg-white border-gray-300'
            ]"></div>
            <span class="ml-2 mr-4 text-sm font-medium"
                :class="{ 'text-gray-700': index <= currentIndex, 'text-gray-400': index > currentIndex }">
                {{ step }}
            </span>
            <div v-if="index < steps.length - 1" class="w-6 h-px bg-gray-300 sm:block hidden"></div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    currentStatus: {
        type: String,
        required: true,
    },
});

const steps = ['Aberto', 'Em atendimento', 'Resolvido', 'Fechado'];

const currentIndex = computed(() => {
    return steps.findIndex(status => status.toLowerCase() === props.currentStatus.toLowerCase());
});
</script>
