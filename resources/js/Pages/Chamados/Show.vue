<template>
    <AppLayout title="Chamado">
        <div class="max-w-6xl mx-auto p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Detalhes do Chamado</h1>
                <Link :href="route('chamados.index')"
                    class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 text-sm">
                Voltar
                </Link>
            </div>

            <div class="grid gap-4">
                <div class="bg-white shadow rounded p-4 border border-gray-100 hover:shadow-md transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ chamado.titulo }}</h2>
                            <p class="text-sm text-gray-500">
                                Categoria: {{ chamado.categoria }} | Prioridade: {{ chamado.prioridade }}
                            </p>
                            <p class="text-sm font-medium mt-1">
                                Status: <span class="text-blue-600">{{ chamado.status }}</span>
                            </p>
                            <p><strong>Descrição:</strong> {{ chamado.descricao }}</p>
                            <p><strong>Criado por:</strong> {{ chamado.nome_usuario }}</p>
                            <p><strong>Criado em:</strong> {{ new Date(chamado.created_at).toLocaleString() }}</p>
                            <p><strong>Anexo:</strong>
                                <span v-if="chamado.anexo" @click="openAnexoModal"
                                    class="underline text-blue-500 hover:cursor-pointer">
                                    Visualizar Anexo
                                </span>
                                <span v-else class="text-gray-500">Nenhum Anexo Encontrado</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                <div
                    class="bg-white shadow rounded p-4 border border-gray-100 hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Status</h2>
                        <Timeline :currentStatus="chamado.status" />
                    </div>
                </div>

                <div class="bg-white shadow rounded p-4 border border-gray-100 hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Respostas</h2>

                    <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        <div v-for="(resposta, index) in props.respostas" :key="index"
                            class="bg-gray-50 border border-gray-200 rounded p-3 text-sm text-gray-700">
                            <p class="text-gray-800 whitespace-pre-line">{{ resposta.mensagem }}</p>
                            <p class="text-xs text-gray-500 mt-1">Por: {{ resposta.user?.name ?? 'Técnico' }}</p>
                        </div>
                        <div v-if="respostas.length === 0" class="text-sm text-gray-400 italic">
                            Nenhuma resposta cadastrada.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="showAnexoModal" @close="closeAnexoModal" max-width="2xl">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Visualização do Anexo</h2>
                <div v-if="anexoUrl" class="w-full h-[500px] border rounded overflow-hidden">
                    <iframe :src="anexoUrl" class="w-full h-full" frameborder="0"></iframe>
                </div>
                <div class="mt-4 flex justify-end">
                    <button @click="closeAnexoModal"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Fechar
                    </button>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Modal from '@/Components/Modal.vue';
import Timeline from '@/Components/Timeline.vue';

const props = defineProps({
    chamado: Object,
    respostas: Array,
});

const showAnexoModal = ref(false);
const anexoUrl = ref('');

const updateStatusForm = useForm({
    status: '',
});

onMounted(() => {
    updateStatusForm.status = props.chamado.status;
});

const openAnexoModal = () => {
    anexoUrl.value = `/storage/${props.chamado.anexo}`;
    showAnexoModal.value = true;
};

const closeAnexoModal = () => {
    showAnexoModal.value = false;
    anexoUrl.value = '';
};

const respostas = ref([
    'Chamado recebido e em análise.',
    'Aguardando retorno do solicitante.',
]);
</script>