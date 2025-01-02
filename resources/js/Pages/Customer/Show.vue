<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerHeader from '@/Pages/Customer/Component/CustomerHeader.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    customer: Object,
    works: Object,
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
            <CustomerHeader :customer="customer" :work="works" :tab="customer.name" />
            <div class="grid grid-cols-1 mt-8 gap-5 sm:gap-4 lg:gap-6 items-center">
                <div class="overflow-x-auto mt-8">
                    <table class="table table-xs">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Work date</th>
                                <th>Products</th>
                                <th>Time spent</th>
                                <th>Status</th>
                                <th>Cost</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="work in works.data" :key="work.id" :value="work.id">
                                <td>{{ work.number }}</td>
                                <td>{{ work.description }}</td>
                                <td>{{ work.category }}</td>
                                <td>{{ work.type }}</td>
                                <td>{{ work.work_date }}</td>
                                <td>{{ work.products.length }}</td>
                                <td>{{ work.time_spent }}</td>
                                <td>
                                    <button>
                                        <span v-if="work.is_completed == 0" class="badge badge-soft badge-warning">Pending</span>
                                        <span v-else class="badge badge-soft badge-success">Completed</span>
                                    </button>
                                </td>
                                <td>{{ work.cost }}</td>
                                <td>
                                    <Link :href="route('work.edit', work.id)">
                                        <button class="btn btn-neutral">View</button>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
