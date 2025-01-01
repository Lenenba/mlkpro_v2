<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import Search from '@/Components/UI/Search.vue';
import Box from '@/Pages/Product/Component/Box.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    filters: Object,
    products: Object,
});

</script>

<template>

    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Products
            </h2>
        </template>

        <BodyLayoutVue>
            <div class="mb-6">
                <!-- Ajout de marge en bas pour espacer Search de la grille -->
                <Search :filters="filters" :routeName="'product.index'" />
            </div>

            <div class="grid grid-cols-1 mt-8 gap-10 sm:grid-cols-2 lg:grid-cols-3 sm:gap-6 lg:gap-8">
                <Box v-for="product in products.data" :key="product.id" :value="product.id" :item="product" :routeName="'product.show'"/>
            </div>
        </BodyLayoutVue>

    </AuthenticatedLayout>
</template>
