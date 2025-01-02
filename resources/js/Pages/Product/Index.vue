<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import Search from '@/Components/UI/Search.vue';
import Box from '@/Pages/Product/Component/Box.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    filters: Object,
    products: Object,
    product: {
        type: Object,
        default: () => ({
            data: [],
        }),
    },
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
            <div class="grid grid-cols-5 gap-4 w-full bg-white shadow p-6 rounded-box items-center">
                <!-- Filtre occupant 4/5 de la largeur -->
                <Search :filters="filters" :routeName="'product.index'" class="col-span-4" />

                <!-- Bouton occupant 1/5 de la largeur -->
                 <Link :href="route('product.create')">
                    <button class="btn btn-accent col-span-1">
                        Add New Product
                    </button>
                </Link>
            </div>


            <div class="grid grid-cols-1 mt-8 gap-10 sm:grid-cols-2 lg:grid-cols-3 sm:gap-6 lg:gap-8">
                <Box v-for="product in products.data" :key="product.id" :value="product.id" :item="product"
                    :routeName="'product.show'" :page="'show'" />
            </div>
        </BodyLayoutVue>

    </AuthenticatedLayout>
</template>
