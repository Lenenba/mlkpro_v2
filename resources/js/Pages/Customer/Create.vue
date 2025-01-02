<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';7
import Form from '@/Pages/Customer/Component/Form.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    customer: {
        type: Object,
        default: () => ({
            data: [],
        }),
    },
});
</script>

<template>

    <Head title="customers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create New Customer
            </h2>
        </template>

        <BodyLayoutVue>
            <Form :customer="customer" />
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
