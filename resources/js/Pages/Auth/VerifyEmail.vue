<template>
    <MainLayout>
            <div class="container w-full flex justify-center content-center">   
                Pentru a avea acces trebuie sa aveti contul verificat
            </div>
            <div class="container w-full flex justify-center content-center mt-3">
                <Link :href="route('verification.send')" method="post" as="button" class="bg-red-500 px-4 py-2 rounded-xl">Retrimite mailul de verificare</Link>
            </div>

    </MainLayout>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import MainLayout from '@/Pages/Layout/MainLayout.vue'
</script>