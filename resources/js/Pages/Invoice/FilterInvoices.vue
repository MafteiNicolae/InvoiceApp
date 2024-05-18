<template>
    <form @submit.prevent="search">
        <div class="mb-8 mt-4 flex flex-col gap-2 lg:flex-row">
            <div class="flex flex-nowrap items-center">
                <input class="input-search" placeholder="Client" type="text" v-model="form.customer" />
            </div>
            <div class="flex flex-nowrap items-center">
                <input class="input-search w-40" placeholder="Numar factura" type="text" v-model="form.invoiceNr"/>
            </div>
            <div class="flex flex-nowrap items-center">
                <input class="input-search-l w-40" placeholder="Data de la" type="date" v-model="form.fromDate"/>
                <input class="input-search-r w-40" placeholder="Data pana la" type="date" v-model="form.toDate"/>
            </div>
            <div class="flex flex-nowrap items-center">
                <input class="input-search-l w-40" placeholder="Scadenta de la" type="date" v-model="form.fromDueDate"/>
                <input class="input-search-r w-40" placeholder="Scadenta pana la" type="date" v-model="form.toDueDate"/>
            </div>
            <div class="flex flex-nowrap items-center">
                <input class="input-search-l w-28" placeholder="pret de la" type="text" v-model="form.fromPrice"/>
                <input class="input-search-r w-28" placeholder="pret pana la" type="text" v-model="form.toPrice"/>
            </div>
            <div class="flex flex-row">
                <button type="submit" class="bg-gray-600 h-8 hover:bg-gray-500 text-white font-medium p-2 rounded-md flex items-center">Cauta</button>
                <button type="reset" @click="clear" class="bg-white h-8 hover:bg-gray-500 text-black hover:text-white font-medium p-2 rounded-md flex items-center border border-gray-600">Sterge</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';

const prosp = defineProps({
    filters: {
        type: Object,
        required: true,
    }
})

const form = useForm({
    customer: prosp.filters.customer ?? null,
    invoiceNr: prosp.filters.invoiceNr ?? null,
    fromDate: prosp.filters.fromDate ?? null,
    toDate: prosp.filters.toDate ?? null,
    fromDueDate: prosp.filters.fromDueDate ?? null,
    toDueDate: prosp.filters.toDueDate ?? null,
    fromPrice: prosp.filters.fromPrice ?? null,
    toPrice: prosp.filters.toPrice ?? null,
})

const search = () => {
    form.get(route('invoice.index'), {
        preserveState: true,
        preserveScroll: true,
    })
}

const clear = () => {
    form.customer= null
    form.invoiceNr= null
    form.fromDate= null
    form.toDate= null
    form.fromDueDate= null
    form.toDueDate= null
    form.fromPrice= null
    form.toPrice= null
    search()
}
</script>