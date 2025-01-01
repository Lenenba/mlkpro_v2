<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerHeader from '@/Pages/Customer/Component/CustomerHeader.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
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
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
