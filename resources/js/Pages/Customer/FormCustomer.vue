<template>
    <form @submit.prevent="emit('postCustomer')">
        <div class="m-1 p-4">
            <label class="form-label" for="name">Nume</label>
            <input type="text" id="name" placeholder="Nume" class="form-input-custom" v-model="form.name"/>
            <div v-if="form.errors.name" class="p-4 text-red-500">
                {{form.errors.name}}
            </div>
        </div>

        <div class="flex flex-col lg:flex-row">
            <div class=" w-full m-1 p-4 lg:w-1/2" >
                <label class="form-label" for="city">Oras</label>
                <input type="text" id="city" placeholder="Oras" class="form-input-custom" v-model="form.city"/>
                <div v-if="form.errors.city" class="p-4 text-red-500">
                    {{form.errors.city}}
                </div>
            </div>

            <div class="w-full m-1 p-4 lg:w-1/2">
                <label class="form-label" for="county">Judet</label>
                <input type="text" id="county" placeholder="Judet" class="form-input-custom" v-model="form.county"/>
                <div v-if="form.errors.county" class="p-4 text-red-500">
                    {{form.errors.county  }}
                </div>
            </div>
        </div>

        <div class="m-1 p-4">
            <label class="form-label" for="street">Strada</label>
            <input type="text" id="street" placeholder="Strada" class="form-input-custom" v-model="form.street"/>
            <div v-if="form.errors.street" class="p-4 text-red-500">
                {{form.errors.street  }}
            </div>
        </div>

        <div class="flex flex-col lg:flex-row">
            <div class="w-full m-1 p-4 lg:w-1/2">
                <label class="form-label" for="street">Numar</label>
                <input type="text" id="number" placeholder="Numar" class="form-input-custom" v-model="form.number"/>
                <div v-if="form.errors.number" class="p-4 text-red-500">
                    {{form.errors.number  }}
                </div>
            </div>

            <div class="w-full m-1 p-4 lg:w-1/2">
                <label class="form-label" for="street">Cod Postal</label>
                <input type="text" id="zipcode" placeholder="Cod postal" class="form-input-custom" v-model="form.zipcode"/>
                <div v-if="form.errors.zipcode" class="p-4 text-red-500">
                    {{form.errors.zipcode  }}
                </div>
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

const emit = defineEmits(['postCustomer'])

</script>