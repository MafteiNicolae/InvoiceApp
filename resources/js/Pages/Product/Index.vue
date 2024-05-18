<template>
    <MainLayout>
        <div class="py-6">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg"> 
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <div class="flex justify-between">
                                <div class="w-1/4 ">
                                    <button type="button" 
                                            class="px-3 py-2.5 text-sm font-medium text-center text-white rounded-md" 
                                            :class="{ 'bg-red-300 cursor-not-allowed': !selectedIds.length, 'bg-red-500': selectedIds.length }"
                                            :disabled="!selectedIds.length"
                                            @click="deleteSelected"
                                        >
                                            Delete Selected
                                    </button>
                                </div>
                                <div class="w-1/4 text-sm text-left rtl:text-right text-gray-500">
                                    <Filter :filters="filters"/>
                                </div>
                            </div>

                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" width="5">
                                            <CheckAll :rows="products.data" v-model="selectedIds" />
                                        </th>
                                        <th scope="col" class="px-6 py-3" width="5">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Nume" name="name" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Description" name="description" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Price" name="price" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Actiuni
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in products.data" :key="product.id">
                                        <td class="px-6 py-4">
                                            <CheckBox :value="product.id" v-model:checked="selectedIds"/>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{products.meta.from + index}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{product.name}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{product.description}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{product.price_currency}}
                                        </td>
                                        <td class="px-6 py-4 flex flex-col lg:flex-row">
                                            <!-- <Link :href="route('product.edit', product)" class="px-4 py-2 border border-gray-500 rounded-md bg-slate-500 text-white">Modifica</Link> -->
                                            <Link :href="route('product.edit', product)" class="ml-3 mt-2 px-4 py-2 border border-gray-500 rounded-md bg-slate-500 text-white">Modifica</Link>
                                            <button @click.prevent="confirmDeleteProduct(product)" class="ml-3 mt-2 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white">Sterge</button>
                                        </td>
                                        <Modal :show="showDeleteModal"  @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-800"> Sigur doriti sa stergeti acest produs? {{prodId.name}}</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <button @click.prevent="deleteProduct(product)" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white">Sterge</button>
                                                    <button @click.prevent="closeModal" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-gray-500 text-white">Anulare</button>    
                                                </div>
                                            </div>
                                        </Modal>
                                        <Modal :show="showDeleteBulkModal" @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-800"> Sigur doriti sa stergeti acest produsul / produsele selectate?</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <button @click.prevent="deleteSelectedAction(selectedIds)" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white">Sterge</button>
                                                    <button @click.prevent="closeModal" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-gray-500 text-white">Anulare</button>    
                                                </div>
                                            </div>
                                        </Modal>
                                    </tr>
                                </tbody>

                            </table>
                            <div v-if="products.meta.links.length" class="w-full justify-center mt-8 mb-8">
                                <Pagination :links="products.meta.links"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Pages/Layout/MainLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import Sortable from '@/Components/Sortable.vue';
import Filter from '@/Components/Filter.vue';
import Modal from '@/Components/Modal.vue';
import CheckBox from '@/Components/CheckBox.vue';
import CheckAll from '@/Components/CheckAll.vue';

import {Link, useForm} from '@inertiajs/vue3';
import {ref} from 'vue';

const prodId = ref({})
const selectedIds = ref([]);

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    filters:{
        type: Object,
        required: true,
    }
})

const showDeleteModal = ref(false);
const showDeleteBulkModal = ref(false);
const form = useForm({})

const confirmDeleteProduct = (id) => {
    prodId.value = id;
    showDeleteModal.value = true;
}

const deleteSelected = () => {
    showDeleteBulkModal.value = true
}

const closeModal = () => {
    showDeleteModal.value = false;
    showDeleteBulkModal.value = false
}

const deleteProduct = (id) => {
    form.delete(route('product.delete', prodId.value), {
        onSuccess: () =>closeModal()
    });
}

const deleteSelectedAction = () => {

    form.delete(route('product.deleteBulk', selectedIds.value.join(',')), {
        onSuccess: () => closeModal()
    })
}

</script>