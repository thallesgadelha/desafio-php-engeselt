<template>
    <transition name="fade">
        <div
            v-if="visible"
            :class="[
                'fixed top-5 right-5 text-white px-4 py-2 rounded shadow-lg z-50',
                bgColor
            ]"
        >
            {{ message }}
        </div>
    </transition>
</template>

<script setup>
import { ref, watch, computed } from 'vue';

const props = defineProps({
    message: String,
    show: Boolean,
    type: {
        type: String,
        default: 'info',
    },
    id: [String, Number]
});

const visible = ref(false);

const bgColor = computed(() => {
    switch (props.type) {
        case 'success':
            return 'bg-green-600';
        case 'error':
            return 'bg-red-600';
        case 'warning':
            return 'bg-yellow-600';
        default:
            return 'bg-blue-600';
    }
});

watch(() => props.id, () => {
    visible.value = true;
    setTimeout(() => {
        visible.value = false;
    }, 3000);
});
</script>
