<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import Stat3 from '@/Components/UI/Stats3.vue';
import StatGaget from '@/Components/UI/StatGaget.vue';
import List from '@/Components/UI/List.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    customers: Array,
    products: Array,
    works: Array,
    quotesWorks: Object,
    estimatesWorks: Object,
    jobsWorks: Object,
    lastCustomers: Object,
    lastWorks: Object,

});

const adaptStatsItems = (type) => {
    if (type === 'customers') {
       return [
            {
                title: "Quotes",
                value: props.quotesWorks.data.length,
                description: "Jan 1st - Feb 1st",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            },
            {
                title: "Estimations",
                value: props.estimatesWorks.data.length,
                description: "↗︎ 400 (22%)",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>`,
            },
            {
                title: "Jobs",
                value: props.jobsWorks.data.length,
                description: "↘︎ 90 (14%)",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>`,
            },
        ]
    }
    else if (type === 'works') {
        return [
            {
                title: "Customers",
                value: props.customers.length,
                description: "Jan 1st - Feb 1st",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            },
            {
                title: "Products",
                value: props.products.length,
                description: "↗︎ 400 (22%)",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>`,
            },
            {
                title: "Works",
                value: props.works.length,
                description: "↘︎ 90 (14%)",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>`,
            },
        ]
    }
};

const adaptCustomersToListItems = (type) => {
    if (type === 'customers') {
        return props.lastCustomers.data.map((customer, index) => {
            return {
                id: customer.id,
                rank: customer.id >= 10? customer.id : "0" + customer.id,
                name: customer.name,
                description: customer.number,
                image: customer.logo,
            };
        });
    } else if (type === 'works') {
        return props.lastWorks.data.map((work, index) => {
            return {
                id: work.id,
                rank: work.id >= 10 ? work.id : "0" + work.id,
                name: work.category,
                description: work.type,
                image: work.image || "https://api.oneapipro.com/images/placeholder?text=D'A&width=150&height=150&color=7d9ea2",
            };
        });
    }
};

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
                <Stat3 :stats="adaptStatsItems('customers')" />
                <Stat3 :stats="adaptStatsItems('works')" />
            </div>
            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-2 sm:gap-6 lg:gap-8">
                <!-- <StatGaget /> -->
                <div class="pt-8 ">
                    <List class="min-h-[410px]" :items="adaptCustomersToListItems('customers')" :type="'customer'">
                        <template #Title> Recent Customers
                        </template>
                    </List>
                </div>
                <div class="pt-8 ">
                    <List class="min-h-[410px]" :items="adaptCustomersToListItems('works')" :type="'work'">
                        <template #Title> Recent Works
                        </template>
                    </List>
                </div>
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
