<template>
    <AppLayout title="Categorias">
        <div class="max-w-6xl mx-auto p-6">
            <h2 class="text-2xl font-bold mb-4">Categorias</h2>
            <div class="bg-white border border-gray-100 p-4 rounded shadow">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Nome</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in categorias" :key="categoria.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ categoria.id }}</td>
                            <td class="px-4 py-2">{{ categoria.nome }}</td>
                        </tr>
                        <tr v-if="!categorias.length">
                            <td colspan="2" class="px-4 py-2 text-center">Nenhuma categoria encontrada</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    categorias: {
        type: Array,
        required: true,
    },
});
</script>