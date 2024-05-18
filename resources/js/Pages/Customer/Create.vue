<template>
    <MainLayout>
        <div class="form-page">
            <div class="form-bg">
                <h1 class="form-title">Creare client</h1>
                    <div class="flex justify-center items-center" v-if="spiner">
                        <Spiner></Spiner>
                    </div>
                    <FormCustomer :form="form" @postCustomer="store">
                        <button type="submit" class="form-submit">Salveaza</button>
                    </FormCustomer>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
    import MainLayout from '@/Pages/Layout/MainLayout.vue';
    import Spiner from '@/Components/Spinner.vue';
    import FormCustomer from '@/Pages/Customer/FormCustomer.vue';
    import {useForm} from '@inertiajs/vue3';
    import {ref} from 'vue';

    const spiner = ref(false);
    const form =useForm({
        name: null,
        city: null, 
        county: null,
        street: null,
        number: null,
        zipcode: null,
    })

    const store = () => {
        form.post(route('customer.store'), {
            onStart: () => spiner.value = true,
            onFinish: () => spiner.value = false,
        })
    };
</script>