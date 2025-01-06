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
                icon: `<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-8 w-8 fill-current text-accent" viewBox="0 0 1024 1024">
                            <path d="M670.5 471.7c-7.1-3.1-14.2-5.9-21.4-8.5 49.8-40.3 81.6-101.8 81.6-170.6 0-121-98.4-219.4-219.4-219.4s-219.4 98.4-219.4 219.4c0 68.9 31.9 130.5 81.7 170.7C219.4 519.6 109 667.8 109 841.3h73.1c0-181.5 147.7-329.1 329.1-329.1 45.3 0 89.1 9 130.2 26.7l29.1-67.2zM511.3 146.3c80.7 0 146.3 65.6 146.3 146.3S592 438.9 511.3 438.9 365 373.2 365 292.6s65.6-146.3 146.3-146.3zM612.5 636.5c0 10.2 5.6 19.5 14.6 24.2l128 67.6c4 2.1 8.4 3.2 12.8 3.2s8.8-1.1 12.8-3.2l128-67.6c9-4.8 14.6-14.1 14.6-24.2s-5.6-19.5-14.6-24.2l-128-67.7c-8-4.2-17.6-4.2-25.6 0l-128 67.7c-9 4.7-14.6 14-14.6 24.2z m155.4-36.6l69.3 36.6-69.3 36.6-69.3-36.6 69.3-36.6z" />
                        </svg>`,
            },
            {
                title: "Products",
                value: props.products.length,
                description: "↗︎ 400 (22%)",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>`,
            },
            {
                title: "Works",
                value: props.works.length,
                description: "↘︎ 90 (14%)",
                icon: ` <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        aria-hidden="true" class="inline-block h-8 w-8 stroke-current">
                        <path fill-rule="evenodd"
                        d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 01-.517.608 7.45 7.45 0 00-.478.198.798.798 0 01-.796-.064l-.453-.324a1.875 1.875 0 00-2.416.2l-.243.243a1.875 1.875 0 00-.2 2.416l.324.453a.798.798 0 01.064.796 7.448 7.448 0 00-.198.478.798.798 0 01-.608.517l-.55.092a1.875 1.875 0 00-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 01-.064.796l-.324.453a1.875 1.875 0 00.2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 01.796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 01.517-.608 7.52 7.52 0 00.478-.198.798.798 0 01.796.064l.453.324a1.875 1.875 0 002.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 01-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 001.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 01-.608-.517 7.507 7.507 0 00-.198-.478.798.798 0 01.064-.796l.324-.453a1.875 1.875 0 00-.2-2.416l-.243-.243a1.875 1.875 0 00-2.416-.2l-.453.324a.798.798 0 01-.796.064 7.462 7.462 0 00-.478-.198.798.798 0 01-.517-.608l-.091-.55a1.875 1.875 0 00-1.85-1.566h-.344zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                        clip-rule="evenodd"></path></svg>`,
            },
        ]
    }
};

const adaptCustomersToListItems = (type) => {
    if (type === 'customers') {
        return props.lastCustomers.data.map((customer, index) => {
            return {
                id: customer.id,
                rank: customer.id >= 10 ? customer.id : "0" + customer.id,
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
                image: work.image,
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
                    <List class="min-h-[410px]" :items="adaptCustomersToListItems('customers')" :type="'customer.index'">
                        <template #Title> Recent Customers
                        </template>
                    </List>
                </div>
                <div class="pt-8 ">
                    <List class="min-h-[410px]" :items="adaptCustomersToListItems('works')" :type="'work.edit'">
                        <template #Title> Recent Works
                        </template>
                    </List>
                </div>
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
