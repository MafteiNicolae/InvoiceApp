<template>
    <div class="min-h-screen py-40" style="background-image: linear-gradient(115deg, #3268a8, #a83269)">
        <div class="container mx-auto">
            <ToastList/>
            <div class="flex flex-col md:flex-row w-10/12 md:w-8/12 bg-white rounded-xl mx-auto shadow-lg overflow-hidden">
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-12 bg-no-repeat bg-cover bg-center" style="background-image: url('Image/Register-Background.png')">
                    <h1 class="text-white text-3xl mb-3">Wellcome</h1>
                    <p class="text-white">Wellcome message on our site</p>
                </div>
                <div class="w-full md:w-1/2 py-16 px-12">
                    <h2 class="text-3xl mb-4">Recuperare parola</h2>
                    <form @submit.prevent="passwordEmail">
                        <div class="m-3 p-4">
                            <label>Introdu adresa de email pentru care doresti recuperarea parolei</label>
                            <input type="text" placeholder="Email" class="w-full rounded-lg mt-3 p-2 b border border-gray-200 focus:border-gray-600" v-model="form.email"/>
                            <div v-if="form.errors.email" class="p-4 text-red-500">
                                {{form.errors.email}}
                            </div>
                        </div>

                        <div class="mt-4 p-4 flex justify-center">
                            <button type="submit" class="bg-green-500 py-1 px-5 rounded-lg font-medium text-2xl text-gray-700">Recupereaza parola</button>
                        </div>
                    </form>
                    {{$status}}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3'
import ToastList from '@/Components/ToastList.vue';

const form = useForm({
    email: null, 
});


const passwordEmail = () => {
    form.post(route('password.email'));
}

</script>