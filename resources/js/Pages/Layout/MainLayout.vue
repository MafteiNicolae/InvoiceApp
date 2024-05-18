<template>
    <div class="relative flex min-h-screen" @click="handleGlobalClick">
        <ToastList/>
     <div class="bg-no-repeat bg-cover bg-center text-cyan-100 duration-300 p-5" 
            :class="{ 'w-20': showSideBar, 'w-72': !showSideBar}"
            style="background-image: url('../../Image/sidebar-3.jpg')"
            @click.stop
        >
            <div class="inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 bg-slate-600 float-left duration-500" :class="{'rotate-[360deg]': showSideBar}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                </svg>
                <span class="text-2xl font-extrabold text-white ml-3 duration-300" :class="{'scale-0': showSideBar}">Blaaa</span>
            </div>
            <ul class="mt-8">
                <li class="flex items-center text-gray-200 text-xl gap-x-4 p-2 mb-5">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </span>
                    <span class="text-base font-medium flex-1" :class="{'hidden': showSideBar}">
                        Dashboard
                    </span>
                </li>
                <li v-if="user" class="relative flex items-center text-gray-200 text-xl gap-x-4 p-2 mb-1 hover:bg-slate-600 hover:text-white hover:rounded-lg" @click="changeSubmenuUser">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </span>
                    <span class="text-base font-medium flex-1" :class="{'hidden': showSideBar}">
                        <div class="flex flex-row items-center justify-between">
                            Clienti
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" :class="{'rotate-180': showSubmenuUser}" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </span>
                    <div v-if="showSubmenuUser && showSideBar" class="absolute left-full ml-2 bg-slate-800 rounded-xl p-2 w-48">
                        <Link :href="route('customer.index')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                            Lista client 
                        </Link>
                        <Link :href="route('customer.create')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                            Creaza client
                        </Link>
                    </div>
                </li>
                <ul v-if="showSubmenuUser && !showSideBar" class="bg-slate-800 rounded-xl">
                    <Link :href="route('customer.index')" class="flex items-center text-gray-200 text-sm gap-x-4 p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                        Lista client
                    </Link>
                    <Link :href="route('customer.create')" class="flex items-center text-gray-200 text-sm gap-x-4 p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                        Creaza client
                    </Link>
                </ul>
                    <li v-if="user" class="relative flex items-center text-gray-200 text-xl gap-x-4 p-2 mb-1 hover:bg-slate-600 hover:text-white hover:rounded-lg" @click="changeSubmenuProduct">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                        </span>
                        <span class="text-base font-medium flex-1" :class="{'hidden': showSideBar}">
                            <div class="flex flex-row items-center justify-between">
                                Produse
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" :class="{'rotate-180': showSubmenuProduct}" >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </span>

                        <div v-if="showSubmenuProduct && showSideBar" class="absolute left-full ml-2 bg-slate-800 rounded-xl p-2 w-48">
                            <Link :href="route('product.index')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                                Lista produse 
                            </Link>
                            <Link :href="route('product.create')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                                Creaza produs
                            </Link>
                        </div>
                    </li>
                        <ul v-if="showSubmenuProduct && !showSideBar" class="bg-slate-800 rounded-xl">
                            <Link :href="route('product.index')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                                Lista produse 
                            </Link>
                            <Link :href="route('product.create')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                                Creaza produs
                            </Link>
                        </ul>
                    <li v-if="user" class=" relative flex items-center text-gray-200 text-xl gap-x-4 p-2 mb-1 hover:bg-slate-600 hover:text-white hover:rounded-lg" @click="changeSubmenuInvoice">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </span>
                        <span class="text-base font-medium flex-1" :class="{'hidden': showSideBar}">
                            <div class="flex flex-row items-center justify-between">
                                Factura
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" :class="{'rotate-180': showSubmenuProduct}" >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </span>

                        <div v-if="showSubmenuInvoice && showSideBar" class="absolute left-full ml-2 bg-slate-800 rounded-xl p-2 w-48">
                            <Link :href="route('invoice.index')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                                Lista facturi
                            </Link>
                            <Link :href="route('invoice.create')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                                Creaza factura
                            </Link>
                        </div>
                    </li>
                        <ul v-if="showSubmenuInvoice && !showSideBar" class="bg-slate-800 rounded-xl">
                            <Link :href="route('invoice.index')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                                Lista facturi
                            </Link>
                            <Link :href="route('invoice.create')" class="block text-gray-200 text-sm p-2 rounded-lg hover:bg-slate-200 hover:text-slate-800">
                                Creaza factura
                            </Link>
                        </ul>
                </ul>
            </div>
            <div class="w-full">
                <div class="flex justify-between shadow bg-gray-500 text-xl text-white font-medium p-5">
                    <div>
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" @click="changeSideBar">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16"
                                                />

                                            </svg>
                    </div>

                        <div class="flex flex-row" v-if="page.props.user">
                            <div class="mr-4 text-white">
                                {{user?.name}}
                            </div>
                            <div class="mr-4">
                                <Link :href="route('logout')" method="post" as="button" class="px-2 py-1 text-sm border font-medium flex justify-center bg-red-600 text-white rounded-lg">Iesire</Link>
                            </div>
                        </div>
                        <div class="flex flex-row" v-else>
                            <div class="mr-4">
                                <Link :href="route('login')" >Login</Link>
                            </div>
                            <div>
                                <Link :href="route('register')">Inregistrare</Link>
                            </div>
                        </div>
                </div>
                <div class="p-8">
                    <slot></slot>
                </div>
            </div>

    </div>

</template>

<script setup>
import {ref, computed} from 'vue';
import {usePage, Link} from '@inertiajs/vue3'
import ToastList from '@/Components/ToastList.vue';

const showSideBar = ref(false);
const showSubmenuUser = ref(false);
const showSubmenuProduct = ref(false);
const showSubmenuInvoice = ref(false);

const changeSideBar = ()=> showSideBar.value = !showSideBar.value
const changeSubmenuUser = ()=> {
    showSubmenuUser.value = !showSubmenuUser.value
    showSubmenuProduct.value = false;
    showSubmenuInvoice.value = false;
    }
const changeSubmenuProduct = ()=> {
    showSubmenuProduct.value = !showSubmenuProduct.value
    showSubmenuUser.value = false;
    showSubmenuInvoice.value = false;
    }
const changeSubmenuInvoice = ()=> {
    showSubmenuInvoice.value = !showSubmenuInvoice.value
    showSubmenuUser.value = false;
    showSubmenuProduct.value = false;
    }

const page = usePage();
const user = computed(
    () => page.props.user
)

const handleGlobalClick = () => {

        showSubmenuUser.value = false;
        showSubmenuProduct.value = false;
        showSubmenuInvoice.value = false;

};
</script>
