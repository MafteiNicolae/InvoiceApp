<template>
    <form @submit.prevent="emit('postProduct')">
        <div class="m-1 p-4">
            <label class="form-label" for="name">Nume</label>
            <input type="text" id="name" placeholder="Nume" class="form-input-custom" v-model="form.name"/>
            <div v-if="form.errors.name" class="p-4 text-red-500">
                {{form.errors.name}}
            </div>
        </div>

        <div class="m-1 p-4">
            <label class="form-label" for="description">Descriere</label>
            <textarea placeholder="Descriere" class="form-input-custom" v-model="form.description">
            </textarea>
            <div v-if="form.errors.description" class="p-4 text-red-500">
                {{form.errors.description}}
            </div>
        </div>

        <div class="m-1 p-4">
            <label class="form-label" for="price">Pret</label>
            <input type="number" id="price" placeholder="Pret" class="form-input-custom" v-model="form.price"/>
            <div v-if="form.errors.price" class="p-4 text-red-500">
                {{form.errors.price  }}
            </div>
        </div>

        <div class="mt-4 p-4 flex justify-center">
            <slot />
        </div>
    </form>
</template>

<script setup>

const props = defineProps({
    form: {
        type: Object,
        required: true,
    }
})

const emit = defineEmits(['postProduct'])
</script>