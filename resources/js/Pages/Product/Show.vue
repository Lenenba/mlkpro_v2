<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import Box from '@/Pages/Product/Component/Box.vue';
import Form from '@/Pages/Product/Component/Form.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    product: Object,
});

// Initialize the form
const form = useForm({
    name: props.product?.name || '',
    category_id: props.product?.category_id || '',
    stock: props.product?.stock || 0,
    minimum_stock: props.product?.minimum_stock || 0,
    description: props.product?.description || '',
    image: props.product?.image || '',
});

// Function to handle form submission
const submit = () => {

    const routeName = props.product?.id ? 'product.update' : 'product.store';
    const routeParams = props.product?.id ? props.product.id : undefined;

    form[props.product?.id ? 'put' : 'post'](route(routeName, routeParams), {
        onSuccess: () => {
            console.log('Product saved successfully!');
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
                Products {{ product.name }}
            </h2>
        </template>

        <BodyLayoutVue>
            <div class="grid grid-cols-1 lg:grid-cols-2 mt-8 gap-5 sm:gap-4 lg:gap-6 items-center">
                <!-- Première colonne avec Box -->
                <Box :item="product" :routeName="'product.show'" :page="'test'" />

                <!-- Dernière colonne qui prend tout l'espace restant -->
                <Form :categories="categories" :product="product" />
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
