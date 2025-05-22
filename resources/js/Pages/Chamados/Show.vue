<template>
    <AppLayout title="Chamado">
        <div class="max-w-6xl mx-auto p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Detalhes do Chamado</h1>
                <Link
                    :href="route('chamados.index')"
                    class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"
                >
                    Voltar
                </Link>
            </div>

            <div class="grid gap-4">
                <div class="bg-white shadow rounded p-4 border border-gray-100 hover:shadow-md transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ chamado.titulo }}</h2>
                            <p class="text-sm text-gray-500">Categoria: {{ chamado.categoria }} | Prioridade: {{ chamado.prioridade }}</p>
                            <p class="text-sm font-medium mt-1">Status: <span class="text-blue-600">{{ chamado.status }}</span></p>
                            <p><strong>Descrição:</strong> {{ chamado.descricao }}</p>
                            <p><strong>Criado por:</strong> {{ chamado.nome_usuario }} </p>
                            <p><strong>Criado em:</strong> {{ new Date(chamado.created_at).toLocaleString() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    chamado: Object,
});
</script>