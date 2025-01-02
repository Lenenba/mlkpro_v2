<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerHeader from '@/Pages/Customer/Component/CustomerHeader.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

// Props
const props = defineProps({
    work: Object,
    customer: Object,
});

// Utility Functions
const calculateTax = (price, rate) => Math.round(Number(price) * Number(rate) * 100) / 100;

const sum = (...values) => {
    // Convert all values to numbers and calculate the total
    return values.reduce((acc, val) => acc + Number(val), 0);
};

const productCost = (products) => {
    return Number(products.reduce((acc, product) => acc + product.price, 0));
};

const totalCost = (work) => {
    const baseCost = Number(work.base_cost); // Ensure it's a number
    const pCost =  productCost(work.products);
    return sum(baseCost, pCost);
};

const calculateTotal = (work) => {
    const tCost = totalCost(work);
    const tps = calculateTax(tCost, 0.05); // TPS 5%
    const tvq = calculateTax(tCost, 0.09975); // TVQ 9.975%
    return sum(tCost, tps, tvq);
};

const getImage = (product) => {
    return product.image
        ? product.image.startsWith('http') ? product.image : `/storage/${product.image}`
        : '/images/default-product.png'; // Default image
};
</script>

<template>

    <Head title="Customer Details" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ work.number }}
                </h2>
            </div>
        </template>

        <CustomerHeader :customer="customer" :work="work" :tab="null" />
        <BodyLayoutVue>
            <h1 class="text-2xl font-bold mb-6">Work product list</h1>
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Cart Items -->
                <div class="w-full lg:w-2/3">
                    <div class="space-y-4">
                        <!-- Cart Item -->
                        <div v-for="product in work.products" :key="product.id" :value="product.id"
                            class="flex items-center bg-white shadow-lg rounded-lg p-4">
                            <div class="w-12 h-12 rounded-lg shadow-md overflow-hidden">
                                <img :src="getImage(product) || 'https://via.placeholder.com/150'" alt="Profile"
                                    class="w-full h-full object-cover" />
                            </div>
                            <div class="ml-4 flex-grow">
                                <h2 class="font-semibold">{{ product.name  }} - {{ product.number }}</h2>
                                <p class="text-sm text-gray-500">{{ product.description }}</p>
                                <p class="text-sm font-medium mt-2">$ {{ product.price }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <input type="number" class="w-12 border rounded-lg" value="1" min="1">
                                <button class="btn btn-error btn-xs">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-lg font-bold mb-4">Order Summary</h2>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <p>Work cost</p>
                                <p>{{ work.base_cost }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p>Product cost</p>
                                <p>{{ productCost(work.products) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p>Tps</p>
                                <p>{{ calculateTax(totalCost(work), 0.05) }} </p>
                            </div>
                            <div class="flex justify-between">
                                <p>Tvq</p>
                                <p>{{ calculateTax(totalCost(work), 0.09975) }}</p>
                            </div>
                            <div class="flex justify-between font-bold text-lg">
                                <p>Total</p>
                                <p>$ {{ calculateTotal(work) }}</p>
                            </div>
                        </div>
                        <button class="btn btn-primary w-full mt-6">Proceed to bills</button>
                    </div>
                </div>
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
