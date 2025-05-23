<template>
    <AppLayout title="Usuários">
        <div class="max-w-6xl mx-auto p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 gap-2">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Usuários</h1>
            </div>

            <div class="bg-white border border-gray-100 p-4 rounded shadow overflow-x-auto">
                <table class="table-auto min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left whitespace-nowrap">Nome</th>
                            <th class="px-4 py-2 text-left whitespace-nowrap">Email</th>
                            <th class="px-4 py-2 text-left whitespace-nowrap">Permissão</th>
                            <th class="px-4 py-2 text-left whitespace-nowrap">Status</th>
                            <th class="px-4 py-2 text-center whitespace-nowrap">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="usuario in usuarios" :key="usuario.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2 whitespace-nowrap">{{ usuario.name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ usuario.email }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ usuario.role }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <span class="text-xs bg-green-800 text-white p-2 rounded-lg">Ativo</span>
                            </td>
                            <td class="px-4 py-2 text-center whitespace-nowrap">
                                <button @click="openEditModal(usuario)"
                                    class="px-2 py-1 text-sm bg-blue-800 text-white rounded hover:bg-blue-700 m-2">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal Update -->
            <Modal :show="showEditModal" @close="closeEditModal" max-width="lg" closeable>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Alterar Permissão & Status</h2>
                    <form @submit.prevent="submitEdit" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                            <input
                                v-model="editForm.name"
                                disabled
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input
                                v-model="editForm.email"
                                disabled
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Permissão</label>
                                <select v-model="editForm.role" class="w-full border rounded text-sm px-3 py-2">
                                    <option value="colaborador">colaborador</option>
                                    <option value="tecnico">tecnico</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select class="w-full border rounded text-sm px-3 py-2">
                                    <option value="">Ativo</option>
                                    <option value="">Inativo</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeEditModal"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                                Cancelar
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </Modal>
        </div>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

defineProps({
    usuarios: {
        type: Array,
        required: true,
    },
});

const showEditModal = ref(false);
const selectedUsuario = ref(null);

const editForm = useForm({
    name: '',
    email: '',
    role: '',
});

const openEditModal = (usuario) => {
    selectedUsuario.value = usuario;
    editForm.name = usuario.name;
    editForm.email = usuario.email;
    editForm.role = usuario.role;
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
    editForm.reset();
    selectedUsuario.value = null;
};

</script>