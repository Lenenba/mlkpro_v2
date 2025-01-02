<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
const props = defineProps({
    products: Object,
    work: Object,
    filters: Object,

});


const form = useForm({
    product_id: '',
    quantity_used: 1,
    unit: 'kg',
    work_id: props.work.id,
});

const addProduct = (productId) => {
    form.product_id = productId;
    form.post(route('work.product.store'), {
        onSuccess: () => {
            console.log('Work saved successfully!');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};

const filterForm = useForm({
    name: props.filters.name || "",
});

// Fonction de filtrage avec un délai pour éviter des appels excessifs
let filterTimeout;
const autoFilter = () => {
    if (filterTimeout) {
        clearTimeout(filterTimeout);
    }
    filterTimeout = setTimeout(() => {
        filterForm.get(route('work.edit', props.work.id), {
            preserveState: true,
            preserveScroll: true,
        });
    }, 300); // Délai de 300ms pour éviter les appels excessifs
};

// Réinitialiser le formulaire lorsque la recherche est vide
watch(() => filterForm.name, (newValue) => {
    if (!newValue) {
        filterForm.name = "";
        autoFilter();
    }
});

</script>

<template>
    <label class="input w-full h-12">
        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </g>
        </svg>
        <input type="search" v-model="filterForm.name" class="grow focus:outline-none focus:ring-0 " placeholder="Search" @input="filterForm.name.length >= 1  ? autoFilter() : null" />
    </label>
    <div class="grid grid-cols-4 mt-8 gap-5 sm:gap-4 lg:gap-6 items-center">
        <div v-for="product in products.data" :key="product.id" :value="product.id"
            class=" h-32 w-42 card card-side bg-base-100 shadow-xl flex flex-row items-center">
            <figure class="h-32 w-32">
                <img :src="product.image" alt="Movie" />
            </figure>
            <div class="card-body flex flex-col items-start">
                <h2 class="card-title text-xs">{{ product.name }}</h2>
                <h2 class="card-title text-xs">{{ product.number }}</h2>
                <div class="card-actions justify-end">
                    <button @click="addProduct(product.id)" class="btn btn-sm btn-neutral">Add product</button>
                </div>
            </div>
        </div>
    </div>
</template>
