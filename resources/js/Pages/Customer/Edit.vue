<template>
        <MainLayout>
        <div class="form-page">
            <div class="form-bg">
                <h1 class="form-title">Modificare client</h1>
                    <div class="flex justify-center items-center" v-if="spiner">
                        <Spiner></Spiner>
                    </div>
                    <FormCustomer :form="form" @postCustomer="updateCustomer">
                        <button type="submit" class="form-submit">Salveaza</button>
                    </FormCustomer>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
    import MainLayout from '@/Pages/Layout/MainLayout.vue';
    import Spiner from '@/Components/Spinner.vue';
    import FormCustomer from '@/Pages/Customer/FormCustomer.vue'
    import {useForm} from '@inertiajs/vue3';
    import {ref} from 'vue';

    const spiner = ref(false);

    const props = defineProps({
        customer: {
            type: Object,
            required: true,
        }
    })

    const form =useForm({
        name: props.customer.name,
        city: props.customer.city, 
        county: props.customer.county,
        street: props.customer.street,
        number: props.customer.number,
        zipcode: props.customer.zipcode,
    })

    const updateCustomer = () =>{
        form.post(route('customer.update', props.customer.id), {
            onStart: () => spiner.value = true,
            onFinish: () => spiner.value = false,
        })
    }

</script>