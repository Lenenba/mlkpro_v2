<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerHeader from '@/Pages/Customer/Component/CustomerHeader.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import TableProduct from '@/Pages/Work/Component/Table.vue';
import ProductList from './Component/ProductList.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';


const props = defineProps({
    customer: Object,
    products: Object,
    work: Object,
    filters: Object,
    workProducts: Array,
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
            <ProductList :products="products" :work="work" :filters="filters"/>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
