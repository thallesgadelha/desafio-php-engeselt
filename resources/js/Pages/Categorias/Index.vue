<template>
    <AppLayout title="Categorias">
        <div class="max-w-6xl mx-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Categorias</h1>
                <button @click="openCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow hover:cursor-pointer">
                    Nova Categoria
                </button>
            </div>
            <div class="bg-white border border-gray-100 p-4 rounded shadow">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Nome</th>
                            <th class="px-4 py-2 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in categorias" :key="categoria.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ categoria.id }}</td>
                            <td class="px-4 py-2">{{ categoria.nome }}</td>
                            <td class="px-4 py-2 text-center">
                                <button @click="openEditModal(categoria)" class="px-2 py-1 text-sm bg-blue-800 text-white rounded hover:bg-blue-700 m-2">Editar</button>
                                <button @click="openDeleteModal(categoria)" class="px-2 py-1 text-sm bg-red-800 text-white rounded hover:bg-red-700 m-2">Deletar</button>
                            </td>
                        </tr>
                        <tr v-if="!categorias.length">
                            <td colspan="3" class="px-4 py-2 text-center">Nenhuma categoria encontrada</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal Create -->
            <Modal :show="showCreateModal" @close="closeCreateModal" max-width="lg" closeable>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Nova Categoria</h2>
                    <form @submit.prevent="submitCreate" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                            <input v-model="createForm.nome"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required />
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeCreateModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                                Cancelar
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </Modal>

            <!-- Modal Update -->
            <Modal :show="showEditModal" @close="closeEditModal" max-width="lg" closeable>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Editar Categoria</h2>
                    <form @submit.prevent="submitEdit" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                            <input v-model="editForm.nome"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required />
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeEditModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                                Cancelar
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </Modal>

            <!-- Modal Delete -->
            <Modal :show="showDeleteModal" @close="closeDeleteModal" max-width="lg" closeable>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Deletar Categoria</h2>
                    <p class="mb-4">Tem certeza que deseja deletar a categoria <strong>{{ selectedCategoria?.nome }}</strong>?</p>
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="closeDeleteModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Cancelar
                        </button>
                        <button @click="submitDelete" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                            Deletar
                        </button>
                    </div>
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
    categorias: {
        type: Array,
        required: true,
    },
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedCategoria = ref(null);

const createForm = useForm({
    nome: '',
});

const editForm = useForm({
    nome: '',
});

const deleteForm = useForm({});

const openCreateModal = () => {
    createForm.reset();
    showCreateModal.value = true;
};

const closeCreateModal = () => {
    showCreateModal.value = false;
    createForm.reset();
};

const submitCreate = () => {
    createForm.post(route('categorias.store'), {
        onSuccess: () => {
            closeCreateModal();
        },
    });
};

const openEditModal = (categoria) => {
    selectedCategoria.value = categoria;
    editForm.nome = categoria.nome;
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
    editForm.reset();
    selectedCategoria.value = null;
};

const submitEdit = () => {
    editForm.put(route('categorias.update', selectedCategoria.value.id), {
        onSuccess: () => {
            closeEditModal();
        },
    });
};

const openDeleteModal = (categoria) => {
    selectedCategoria.value = categoria;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    selectedCategoria.value = null;
};

const submitDelete = () => {
    deleteForm.delete(route('categorias.destroy', selectedCategoria.value.id), {
        onSuccess: () => {
            closeDeleteModal();
        },
    });
};
</script>