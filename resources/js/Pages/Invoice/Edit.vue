<template>
    <MainLayout>
<div class="container">

 <div class="invoices">
        
        <div class="card__header">
            <div>
                <h2 class="invoice__title">Modifica factura</h2>
            </div>
            <div>
                
            </div>
        </div>

        <div class="card__content">
            <div class="card__content--header">
                <div>
                    <p class="my-1">Client</p>
                    <select name="" id="" class="input" v-model="form.customer_id">
                        <option value="" disabled>Selecteaza client</option>
                        <option :value="customer.id" v-for="customer in customers" :key="customer.id">{{customer.name}}</option>
                    </select>
                    <div v-if="form.errors.customer_id" class="p-4 text-red-500">
                        {{form.errors.customer_id}}
                    </div>
                </div>
                <div>
                    <p class="my-1">Data</p> 
                    <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="form.date"> 
                    <p class="my-1">Data scandenta</p> 
                    <input id="due_date" type="date" class="input" v-model="form.due_date">
                </div>
                <div>
                    <p class="my-1">Numar</p> 
                    <input type="text" class="input" v-model="form.number"> 
                    <p class="my-1">Referinta(Optional)</p> 
                    <input type="text" class="input" v-model="form.reference">
                </div>
            </div>
            <br><br>
            <div class="table">

                <div class="table--heading2">
                    <p>Nume produs</p>
                    <p>Pret</p>
                    <p>Cant</p>
                    <p>Total</p>
                    <p></p>
                </div>
    
                <div class="table--items2" v-for="(item, index) in form.listCart" :key="index">
                    <p>#{{item.name}} </p>
                    <p>
                        <input type="text" class="input" v-model="item.price">
                    </p>
                    <p>
                        <input type="text" class="input" v-model="item.quantity">
                    </p>
                    <p>
                        $ {{item.quantity * item.price}}
                    </p>
                    <p style="color: red; font-size: 24px;cursor: pointer;" @click="removeItem(index)">
                        &times;
                    </p>
                </div>
                <div style="padding: 10px 30px !important;">
                    <button class="btn btn-sm btn__open--modal" @click="openModal()">Adauga produs</button>
                </div>
            </div>

            <div class="table__footer">
                <div class="document-footer" >
                    <p>Termene si conditii</p>
                    <textarea cols="50" rows="7" class="textarea" v-model="form.terms_and_conditions"></textarea>
                </div>
                <div>
                    <div class="table__footer--subtotal">
                        <p>Subtotal</p>
                        <span>$ {{subtotal()}}</span>
                    </div>
                    <div class="table__footer--discount">
                        <p>Reducere</p>
                        <input type="text" class="input" v-model="form.discount">
                    </div>
                    <div class="table__footer--total">
                        <p>Total</p>
                        <span>$ {{total()}}</span>
                    </div>
                </div>
            </div>

           
        </div>
        <div class="card__header" style="margin-top: 40px;">
            <div>
                
            </div>
            <div>
                <Link :href="route('invoice.index')" class="btn btn-secondary mr-5">Inapoi</Link>
                <a class="btn btn-secondary" @click.prevent="onSave">
                    Salveaza
                </a>
            </div>
        </div>
        
    </div>

    <div class="modal main__modal" :class="{'show': showModal}">
        <div class="modal__content">
            <span class="modal__close btn__close--modal" @click="closeModal">×</span>
            <h3 class="modal__title">Adauga produs</h3>
            <hr><br>
            <form @submit.prevent="addCart(item)">
                <div class="modal__items">
                    <select class="input my-1" v-model="item">
                        <option value="None">None</option>
                        <option :value="product" v-for="product in props.products" :key="product.id">{{product.name}}</option>
                    </select>
                </div>
                <br><hr>
                <div class="model__footer">
                    <button class="btn btn-light mr-2 btn__close--modal" @click="closeModal">
                        Anulare
                    </button>
                    <button type="submit" class="btn btn-light btn__close--modal" >
                        Salveaza
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Pages/Layout/MainLayout.vue';
import {useForm, Link} from '@inertiajs/vue3';
import {ref, computed} from 'vue';

const showModal =ref(false);

const props = defineProps({
    invoice: {
        type: Object,
        required: true,
    },
    customers: {
        type: Object,
        required: true,
    },
    products: {
        type: Object,
        required: true,
    },
})


const form =useForm({
        number: props.invoice.number,
        customer_id: props.invoice.customer_id,
        date: props.invoice.date,
        due_date: props.invoice.due_date,
        reference: props.invoice.reference,
        terms_and_conditions: props.invoice.terms_and_conditions,
        discount: props.invoice.discount,
        sub_total: props.invoice.sub_total,
        total: props.invoice.total,
        listCart: props.invoice.products.map((item) => {
            return {
                id: item.id,
                name: item.name,
                description: item.description,
                price: item.price,
                quantity: item.pivot.quantity,
            }
        }),
})

const openModal = () => {
    showModal.value=true
}

const closeModal = () => {
    showModal.value=false
}

const removeItem = (item) => {
    form.listCart.splice(item, 1)
}
const addCart = (item) => {
    const itemcart = {
        id: item.id,
        name: item.name,
        description: item.description,
        price: item.price,
        created_at: item.created_at,
        updated_at: item.updated_at,
        quantity: item.quantity,
    }
    form.listCart.push(itemcart)
        closeModal()
}

const subtotal = () => {
    let total = 0
    form.listCart.map((data) => {
        total = total + (data.quantity*data.price)
    })
    return total
}

const total = () => {
    return subtotal() - form.discount
}

const onSave = () => {

    form.sub_total = subtotal();
    form.total = total();

    form.post(route('invoice.update', props.invoice.id));
}

</script>