<template>
    <MainLayout>
        <div class="form-page">
            <div class="form-bg">
                <h1 class="form-title">Creare produs</h1>
                <div class="flex justify-center items-center" v-if="spiner">
                    <Spinner/>
                </div>
                <FormProduct :form="form" @postProduct="store">
                    <button type="submit" class="form-submit">Salveaza</button>
                </FormProduct>
            </div>
        </div>
    </MainLayout>    
</template>

<script setup>
import MainLayout from '@/Pages/Layout/MainLayout.vue';
import FormProduct from '@/Pages/Product/FormProduct.vue';
import Spinner from '@/Components/Spinner.vue';

import {useForm} from '@inertiajs/vue3';
import {ref} from 'vue';

const spiner= ref(false);

const form = useForm({
    name: null,
    description: null,
    price: null,
})

const store = () => form.post(route('product.store'),{
    onStart: () => spiner.value = true,
    onFinish: () => spiner.value = false,
});

</script>