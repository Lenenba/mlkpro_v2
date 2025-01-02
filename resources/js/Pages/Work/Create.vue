<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import Form from '@/Pages/Work/Component/Form.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    work: Object,
    customer: Object,
});

// Initialize the form
const form = useForm({
    name: '',
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
            <Form :work="work" :customer="customer" />
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
