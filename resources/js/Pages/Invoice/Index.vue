<template>
    <MainLayout>
        <div class="py-6">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg"> 
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <div class="flex justify-between pb-4">
                                <div class=" "> 
                                    <button type="button" 
                                            class="px-3 py-2.5 text-sm font-medium text-center text-white rounded-md" 
                                            :class="{ 'bg-red-300 cursor-not-allowed': !selectedIds.length, 'bg-red-500': selectedIds.length }"
                                            :disabled="!selectedIds.length"
                                            @click="deleteSelected"
                                        >
                                            Sterge selctie
                                    </button>
                                </div>
                                   <div class="flex justify-center text-sm text-left rtl:text-right text-gray-500">
                                        <Link :href="route('invoice.create')" class="text-center px-3 py-1 bg-green-600 text-white text-lg rounded-lg">Factura noua</Link>
                                    </div>
                            </div>
                            <div class="flex justify-center">
                                <div class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <FilterInvoices :filters="filters"/>
                                </div>
                            </div>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" width="5">
                                            <CheckAll :rows="invoices.data" v-model="selectedIds" />
                                        </th>
                                        <th scope="col" class="px-6 py-3" width="5">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Customer" name="customer_id" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Number" name="number" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Data" name="date" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Due date" name="due_date" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Total" name="total" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Actiuni
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(invoice, index) in invoices.data" :key="invoice.id">
                                        <td class="px-6 py-4">
                                            <CheckBox :value="invoice.id" v-model:checked="selectedIds"/>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{invoices.from + index}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{invoice.customer.name}} {{invoice.customer_id}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{invoice.number}}
                                        </td>
                                        <td class="px-6 py-4">  
                                            {{invoice.date}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{invoice.due_date}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{invoice.total}} $
                                        </td>
                                        <td class="px-6 py-4 flex flex-col lg:flex-row">
                                            <Link :href="route('invoice.show', invoice)" class="ml-3 mt-2 px-4 py-2 border border-gray-500 rounded-md bg-yellow-500 text-black">Afiseaza</Link>
                                            <Link :href="route('invoice.edit', invoice)" class="ml-3 mt-2 px-4 py-2 border border-gray-500 rounded-md bg-slate-500 text-white">Modifica</Link>
                                            <button @click.prevent="confirmDeleteCustomer(invoice)" class="ml-3 mt-2 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white">Sterge</button>
                                        </td>
                                        <Modal :show="showDeleteModal" @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-800"> Sigur doriti sa stergeti aceasta factura? {{invoiceToDelete.number}}</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <button @click.prevent="deleteInvoice" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white">Sterge</button>
                                                    <button @click.prevent="closeModal" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-gray-500 text-white">Anulare</button>    
                                                </div>
                                            </div>
                                        </Modal>
                                        <Modal :show="showDeleteBulkModal" @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-800"> Sigur doriti sa stergeti factura /facturile selectatate?</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <button @click.prevent="deleteSelectedAction(selectedIds)" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white">Sterge</button>
                                                    <button @click.prevent="closeModal" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-gray-500 text-white">Anulare</button>    
                                                </div>
                                            </div>
                                        </Modal>
                                    </tr>
                                </tbody>

                            </table>
                            <div v-if="invoices.links.length" class="w-full justify-center mt-8 mb-8">
                                <Pagination :links="invoices    .links"/>
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
import FilterInvoices from '@/Pages/Invoice/FilterInvoices.vue';
import Sortable from '@/Components/Sortable.vue';
import Modal from '@/Components/Modal.vue';
import CheckBox from '@/Components/CheckBox.vue';
import CheckAll from '@/Components/CheckAll.vue';

import {Link, useForm} from '@inertiajs/vue3';
import {ref} from 'vue';

const selectedIds = ref([]);
const showDeleteModal = ref(false);
const showDeleteBulkModal = ref(false);
const invoiceToDelete = ref();
const form = useForm({});

const props = defineProps({
    invoices: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    }
})

const confirmDeleteCustomer = (id) => {
    invoiceToDelete.value = id;
    showDeleteModal.value = true;
}

const closeModal = () => {
    showDeleteModal.value = false;
    showDeleteBulkModal.value = false;
}

const deleteInvoice = () => {
    form.delete(route('invoice.delete', invoiceToDelete.value), {
        onSuccess: () => closeModal()
    })
}

const deleteSelected = () => {
    showDeleteBulkModal.value = true
}

const deleteSelectedAction = () => {
       form.delete(route('invoice.deleteBulk', selectedIds.value.join(',')), {
        onSuccess: () => closeModal()
    }) 
}
</script>