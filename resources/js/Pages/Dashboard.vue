<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import Stat3 from '@/Components/UI/Stats3.vue';
import StatGaget from '@/Components/UI/StatGaget.vue';
import List from '@/Components/UI/List.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    customers: Object,

});

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
                <Stat3 :customers="customers" />
                <Stat3 />
            </div>
            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-2 sm:gap-6 lg:gap-8">
                <!-- <StatGaget /> -->
                <div class="pt-8 ">
                    <List class="min-h-[410px]">
                        <template #Title> Recent Customers
                        </template>
                    </List>
                </div>
                <div class="pt-8 ">
                    <List class="min-h-[410px]">
                        <template #Title> Recent Works
                        </template>
                    </List>
                </div>
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
