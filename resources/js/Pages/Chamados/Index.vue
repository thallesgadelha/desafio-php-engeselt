<template>
    <AppLayout title="Chamados">
        <Toast :message="toastMessage" :type="'success'" :id="toastId" />
        <div class="max-w-5xl mx-auto p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Meus Chamados</h1>
                <div class="flex flex-wrap items-center gap-4">
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
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router, Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import Toast from '@/Components/Toast.vue';

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
</script>
