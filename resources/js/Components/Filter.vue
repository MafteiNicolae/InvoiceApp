    <template>
        <form @submit.prevent="startSearch">
            <div class="mb-8 mt-4 flex flex-wrap gap-2 items-center">
                <input 
                        type="text" 
                        placeholder="Cauta..." 
                        v-model="form.search"
                        class="px-4 h-8 flex items-center placeholder:text-gray-400 dark:placeholder:text-gray-600 border border-gray-200 dark:border-gray-600 rounded-md text-sm font-medium text-gray-600 dark:text-gray-400 dark:bg-gray-800">
                <button type="submit" class="bg-gray-600 h-8 hover:bg-gray-500 text-white font-medium p-2 rounded-md flex items-center">Cauta</button>
            </div>
        </form>
    </template>

    <script setup>
    import {useForm} from '@inertiajs/vue3';

    const props = defineProps({
        filters: {
            type: Object,
            required: true,
        }
    })

    const form = useForm({
        search: props.filters.search ?? null 
    })


    const startSearch = () => {
  
            form.get(route(route().current()), {
                preserveState: true,
                preserveScroll: true,
            })
        
    }

    </script>