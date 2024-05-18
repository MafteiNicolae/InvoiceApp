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
                                            <CheckAll :rows="customers.data" v-model="selectedIds" />
                                        </th>
                                        <th scope="col" class="px-6 py-3" width="5">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Nume" name="name" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Oras" name="city" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <Sortable class="sortable" label="Judet" name="county" />
                                        </th>
                                        <th scope="col" class="px-6 py-3 hidden lg:table-cell">
                                            <Sortable class="sortable" label="Strada" name="street" />
                                        </th>
                                        <th scope="col" class="px-6 py-3 hidden lg:table-cell">
                                            Numar
                                        </th>
                                        <th scope="col" class="px-6 py-3 hidden lg:table-cell">
                                            <Sortable class="sortable" label="Cod postal" name="zipcode" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Actiuni
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(customer, index) in customers.data" :key="customer.id">
                                        <td class="px-6 py-4">
                                            <CheckBox :value="customer.id" v-model:checked="selectedIds"/>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{customers.meta.from + index}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{customer.name}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{customer.city}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{customer.county}}
                                        </td>
                                        <td class="px-6 py-4 hidden lg:table-cell">
                                            {{customer.street}}
                                        </td>
                                        <td class="px-6 py-4 hidden lg:table-cell">
                                            {{customer.number}}
                                        </td>
                                        <td class="px-6 py-4 hidden lg:table-cell">
                                            {{customer.zipcode}}
                                        </td>
                                        <td class="px-6 py-4 flex flex-col lg:flex-row">
                                            <Link :href="route('customer.edit', customer)" class="px-4 py-2 border border-gray-500 rounded-md bg-slate-500 text-white">Modifica</Link>
                                            <button @click.prevent="confirmDeleteCustomer(customer)" class="ml-3 mt-2 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white lg:mt-0">Sterge</button>
                                        </td>
                                        <Modal :show="showDeleteModal" @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-800"> Sigur doriti sa stergeti acest utilizator {{customerId.name}}?</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <button @click.prevent="deleteUser(customer.id)" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white">Sterge</button>
                                                    <button @click.prevent="closeModal" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-gray-500 text-white">Anulare</button>    
                                                </div>
                                            </div>
                                        </Modal>
                                        <Modal :show="showDeleteBulkModal" @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-800"> Sigur doriti sa stergeti acest utilizatorul / utilizatorii selectati?</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <button @click.prevent="deleteSelectedAction(selectedIds)" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-red-500 text-white">Sterge</button>
                                                    <button @click.prevent="closeModal" class="ml-3 px-4 py-2 border border-gray-500 rounded-md bg-gray-500 text-white">Anulare</button>    
                                                </div>
                                            </div>
                                        </Modal>
                                    </tr>
                                </tbody>

                            </table>
                            <div v-if="customers.meta.links.length" class="w-full justify-center mt-8 mb-8">
                                <Pagination :links="customers.meta.links"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Pages/Layout/MainLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import Filter from '@/Components/Filter.vue'
import Sortable from '@/Components/Sortable.vue'
import Modal from '@/Components/Modal.vue'
import CheckBox from '@/Components/CheckBox.vue'
import CheckAll from '@/Components/CheckAll.vue'
import {Link, useForm} from '@inertiajs/vue3'
import {ref} from 'vue'

const selectedIds = ref([]);

const props = defineProps({
    customers: {
        type: Object,
        required: true,
    },
    filters:{
        type: Object,
        required: true,
    }
})

const form = useForm({})
const customerId = ref({})

const showDeleteModal = ref(false);
const showDeleteBulkModal = ref(false);

const confirmDeleteCustomer = (id) => {
    customerId.value = id
    showDeleteModal.value = true
}

const deleteSelected = () => {
    showDeleteBulkModal.value = true
}

const closeModal = () => {
    showDeleteModal.value = false
    showDeleteBulkModal.value = false
}

const deleteUser = () => {
    form.delete(route('customer.delete', customerId.value), {
        onSuccess: () => closeModal()
    })
}

const deleteSelectedAction = () => {

    form.delete(route('customer.deleteBulk', selectedIds.value.join(',')), {
        onSuccess: () => closeModal()
    })
}

</script>