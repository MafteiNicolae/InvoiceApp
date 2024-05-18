<template>
    <TransitionGroup 
        tag="div"
        enter-from-class="translate-x-full opacity-0"
        enter-active-class="duration-500"
        leave-active-class="duration-500"
        leave-to-class="translate-x-full opacity-0"
        class="fixed top-4 right-4 z-50 space-y-4 w-full max-w-xs">
        <Toast 
                v-for="(item) in toast.items" 
                :key="item.key" 
                :message="item.message"
                @remove="remove(index)"
                />
    </TransitionGroup>
</template>

<script setup>
import Toast from '@/Components/Toast.vue'
import {ref, onUnmounted} from 'vue';
import {router , usePage} from '@inertiajs/vue3'
import toast from '@/Stores/toast.js';

const page = usePage();

let removeFinishEventListener = router.on('finish', () => {
    if(page.props.message){
        toast.add({
            message: page.props.message,
        })
    }
});

onUnmounted (()=> removeFinishEventListener());

const remove = (item) => toast.remove(item);
</script>