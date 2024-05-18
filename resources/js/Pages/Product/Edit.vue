<template>
    <MainLayout>
        <div class="form-page">
            <div class="form-bg">
                <h1 class="form-title">Modificare produs</h1>
                    <div class="flex justify-center items-center" v-if="spiner">
                        <Spinner/>
                    </div>
                    <FormProduct :form="form" @postProduct="store">
                        <button type="submit" class="form-submit">Modifica</button>
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

const props = defineProps({
    product: {
        type: Object,
        required: true,
    }
})

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
})

const store = () => {
    form.post(route('product.update', props.product.id), {
        onStart: () => spiner.value = true,
        onFinish: () => spiner.value = false,
    });
}

</script>