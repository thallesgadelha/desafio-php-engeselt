<template>
    <AppLayout title="Chamado">
        <div class="max-w-6xl mx-auto p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Detalhes do Chamado</h1>
                <Link :href="route('tecnico.chamados.index')" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 text-sm">
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
                                <span v-if="chamado.anexo" @click="openAnexoModal" class="underline text-blue-500 hover:cursor-pointer">
                                    Visualizar Anexo
                                </span>
                                <span v-else class="text-gray-500">Nenhum Anexo Encontrado</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                <div class="bg-white shadow rounded p-4 border border-gray-100 hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Status</h2>
                        <Timeline :currentStatus="chamado.status" />
                    </div>

                    <div class="flex justify-end items-center gap-2 mt-6">
                        <select v-model="updateStatusForm.status" class="border rounded px-3 py-2 text-sm">
                            <option value="Aberto">Aberto</option>
                            <option value="Em atendimento">Em atendimento</option>
                            <option value="Resolvido">Resolvido</option>
                            <option value="Fechado">Fechado</option>
                        </select>
                        <button @click="alterarStatus" :disabled="updateStatusForm.processing"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm disabled:opacity-50">
                            Alterar Status
                        </button>
                    </div>
                </div>

                <div class="bg-white shadow rounded p-4 border border-gray-100 hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Respostas</h2>

                    <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        <div v-for="(resposta, index) in respostas" :key="index" class="bg-gray-50 border border-gray-200 rounded p-3 text-sm text-gray-700">
                            {{ resposta }}
                        </div>
                        <div v-if="respostas.length === 0" class="text-sm text-gray-400 italic">
                            Nenhuma resposta cadastrada.
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nova Resposta</label>
                        <textarea v-model="novaResposta" rows="3"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            placeholder="Escreva sua resposta aqui...">
                        </textarea>
                        <div class="flex justify-end mt-2">
                            <button @click="adicionarResposta"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm">
                                Adicionar
                            </button>
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
                    <button @click="closeAnexoModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
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

const novaResposta = ref('');

const adicionarResposta = () => {
    if (novaResposta.value.trim()) {
        respostas.value.push(novaResposta.value.trim());
        novaResposta.value = '';
    }
};

const alterarStatus = () => {
    updateStatusForm.patch(route('tecnico.chamados.status', props.chamado.id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            props.chamado.status = updateStatusForm.status;
        },
        onError: (errors) => {
            console.error('Erro ao atualizar status:', errors);
        },
    });
};
</script>