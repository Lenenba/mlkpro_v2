<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    customer: [],
});

// Initialize the form
const form = useForm({
    name: '',
});

// Function to handle form submission
const submit = () => {
    form.post(route('customer.store'), {
        onSuccess: () => {
            console.log('customer had successfully created !');
            emit('close');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
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
            <div class="grid grid-cols-1 lg:grid-cols-2 mt-8 gap-5 sm:gap-4 lg:gap-6 items-center">
                <!-- Dernière colonne qui prend tout l'espace restant -->
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
