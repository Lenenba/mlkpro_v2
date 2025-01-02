<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerHeader from '@/Pages/Customer/Component/CustomerHeader.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import TableProduct from '@/Pages/Work/Component/Table.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';


const props = defineProps({
    customer: Object,
    products: Object,
    work: Object,
    filters: Object,
    workProducts: Array,
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

    <Head title="customers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ customer.company_name }}
            </h2>
        </template>

        <BodyLayoutVue>
            <CustomerHeader :customer="customer" :work="work" :tab="null" />
            <TableProduct :products="workProducts" :work="work"/>

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
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
