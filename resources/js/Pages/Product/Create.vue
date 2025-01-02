<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import Box from '@/Pages/Product/Component/Box.vue';
import Form from '@/Pages/Product/Component/Form.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    product: [],
});

// Initialize the form
const form = useForm({
    name: '',
    category_id: '',
    stock: 0,
    minimum_stock: 0,
    description: '',
    image: '',
});

// Function to handle form submission
const submit = () => {
    form.post(route('product.store'), {
        onSuccess: () => {
            console.log('Product had successfully created !');
            emit('close');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
</script>

<template>

    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create New Product
            </h2>
        </template>

        <BodyLayoutVue>
            <div class="grid grid-cols-1 lg:grid-cols-2 mt-8 gap-5 sm:gap-4 lg:gap-6 items-center">
                <!-- Dernière colonne qui prend tout l'espace restant -->
                <Form :categories="categories" :product="product" />
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
