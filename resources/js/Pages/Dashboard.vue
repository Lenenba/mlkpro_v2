<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import Stat3 from '@/Components/UI/Stats3.vue';
import Stat1 from '@/Components/UI/Stat1.vue';
import StatGaget from '@/Components/UI/StatGaget.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>
        <BodyLayoutVue>
            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-2 sm:gap-6 lg:gap-8">
                <Stat3 />
                <Stat3 />
            </div>
            <StatGaget />
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
