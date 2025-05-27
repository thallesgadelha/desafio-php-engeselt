<template>
    <AppLayout title="Chamados">
        <Toast :message="toastMessage" :type="'success'" :id="toastId" />
        <div class="max-w-5xl mx-auto p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Meus Chamados</h1>
                <div class="flex flex-wrap items-center gap-4">
                    <p @click="openDataModal()" class="text-md text-gray-800 hover:text-blue-800 hover:cursor-pointer hover:underline">Exportar Dados</p>
                    <select v-model="filters.status" @change="applyFilters" class="border py-2 rounded text-sm">
                        <option value="">Todos os Status</option>
                        <option value="Aberto">Aberto</option>
                        <option value="Em atendimento">Em atendimento</option>
                        <option value="Resolvido">Resolvido</option>
                        <option value="Fechado">Fechado</option>
                    </select>

                    <select v-model="filters.prioridade" @change="applyFilters" class="border py-2 rounded text-sm">
                        <option value="">Todas as Prioridades</option>
                        <option value="Baixa">Baixa</option>
                        <option value="Média">Média</option>
                        <option value="Alta">Alta</option>
                    </select>

                    <Link href="/chamados/create"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                    Novo Chamado
                    </Link>
                </div>
            </div>

            <div v-if="chamados.length === 0" class="text-gray-500 text-center py-10">
                Nenhum chamado encontrado.
            </div>

            <div v-else class="grid gap-4">
                <div v-for="chamado in chamados" :key="chamado.id"
                    class="bg-white shadow rounded p-4 border border-gray-100 hover:shadow-md transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ chamado.titulo }}</h2>
                            <p class="text-sm text-gray-500">Categoria: {{ chamado.categoria }} | Prioridade: {{
                                chamado.prioridade }}
                            </p>
                            <p class="text-sm font-medium mt-1">Status: <span class="text-blue-600">{{ chamado.status
                                    }}</span></p>
                        </div>
                        <Link :href="`/chamados/${chamado.id}`" class="text-sm text-blue-600 hover:underline">Visualizar
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
import { ref, onMounted } from 'vue';
import { router, Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import Toast from '@/Components/Toast.vue';
import Modal from '@/Components/Modal.vue';

defineProps({ chamados: Array })

const filters = ref({
    status: '',
    prioridade: '',
})

function applyFilters() {
    router.get('/chamados',
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

const page = usePage();
const toastMessage = ref('');
const toastId = ref(0);

onMounted(() => {
    const toast = page.props.flash?.toast;

    if (toast) {
        toastMessage.value = toast;
        toastId.value = Date.now();
    }
});

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
    pdfUrl.value = route('chamados.exportar.pdf');
    mostrarIframe.value = true;
};

</script>
