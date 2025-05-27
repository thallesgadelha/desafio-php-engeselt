<template>
    <AppLayout title="Chamados">
        <div class="max-w-6xl mx-auto p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Chamados Técnicos</h1>
                <div class="flex items-center gap-4">
                    <p @click="openDataModal()" class="text-md text-gray-800 hover:text-blue-800 hover:cursor-pointer hover:underline">Exportar Dados</p>
                    <select v-model="filters.status" @change="applyFilters" class="border py-2 rounded text-sm">
                        <option value="">Todos os Status</option>
                        <option>Aberto</option>
                        <option>Em atendimento</option>
                        <option>Resolvido</option>
                        <option>Fechado</option>
                    </select>
                    <select v-model="filters.prioridade" @change="applyFilters" class="border py-2 rounded text-sm">
                        <option value="">Todas as Prioridades</option>
                        <option>Baixa</option>
                        <option>Média</option>
                        <option>Alta</option>
                    </select>
                </div>
            </div>

            <div v-if="chamados.length === 0" class="text-center text-gray-500 py-10">
                Nenhum chamado encontrado com os filtros aplicados.
            </div>

            <div v-else class="space-y-4">
                <div v-for="chamado in chamados" :key="chamado.id"
                    class="bg-white border border-gray-100 p-4 rounded shadow hover:shadow-md transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ chamado.titulo }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Categoria: {{ chamado.categoria }} | Prioridade: {{ chamado.prioridade }}
                            </p>
                            <p class="text-sm font-medium mt-1">Status: <span class="text-blue-600">{{ chamado.status
                            }}</span></p>
                        </div>
                        <Link :href="`/tecnico/chamados/${chamado.id}`" class="text-sm text-blue-600 hover:underline">
                        Ver Detalhes
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="showDataModal" @close="closeDataModal" max-width="lg" closeable>
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Exportar Dados</h2>

                <div class="bg-gray-100 p-6 rounded-md space-y-4">
                    <div class="flex space-x-4">
                        <button @click="mostrarPDF"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
                            Exportar PDF
                        </button>
                        <a class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            Exportar Excel (.xlsx)
                        </a>
                    </div>

                    <div v-if="mostrarIframe" class="mt-4 border border-gray-300 rounded overflow-hidden">
                        <iframe :src="pdfUrl" class="w-full h-[500px]" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button @click="closeDataModal"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Fechar
                    </button>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Modal from '@/Components/Modal.vue';

defineProps({ chamados: Array })

const filters = ref({
    status: '',
    prioridade: '',
})

function applyFilters() {
    router.get('/tecnico/chamados',
        {
            status: filters.value.status || undefined,
            prioridade: filters.value.prioridade || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
}

const showDataModal = ref(false);
const mostrarIframe = ref(false);
const pdfUrl = ref('');

const openDataModal = () => {
    showDataModal.value = true;
};

const closeDataModal = () => {
    showDataModal.value = false;
    mostrarIframe.value = false;
};

const mostrarPDF = () => {
  const params = new URLSearchParams({
    status: filters.value.status,
    prioridade: filters.value.prioridade
  });

  pdfUrl.value = route('chamados.exportar.pdf') + '?' + params.toString();
  mostrarIframe.value = true;
};

</script>
