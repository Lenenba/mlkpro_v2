<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    customer: Object,
    work: Object,
    tab: String,
});
const cutText = (text, length) => {
    return text.length > length ? text.substring(0, length) + '...' : text;
};

const getImage = (customer) => {
    if (!customer.logo) return '/logos/default-customer.png'; // logo par défaut si aucune n'est fournie
    return customer.logo.startsWith('http') ? customer.logo : `/storage/${customer.logo}`;
};
</script>
<template>
    <div class="flex flex-row gap-7 max-w-[90rem] mx-auto pt-4">
        <!-- Customer Details -->
        <div class="flex-1">
            <section class="container px-4 mx-auto">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div>
                        <Link :href="route('customer.show', customer.id)">
                        <div class="flex items-center gap-x-3">
                            <div class="flex items-center">
                                <div class="w-16 h-16 rounded-lg shadow-md overflow-hidden">
                                    <img :src="getImage(customer) || 'https://via.placeholder.com/150'" alt="Profile"
                                        class="w-full h-full object-cover" />
                                </div>
                                <div class="ml-4 text-left">
                                    <h2 class="text-sm font-bold text-gray-800">
                                        {{ customer.company_name || 'Unknown User' }}
                                    </h2>
                                    <h2 class="text-xs text-gray-800">
                                        {{ customer.number || 'Unknown User' }}
                                    </h2>
                                    <p class="text-xs text-gray-600">
                                        {{ customer.name || 'Role not specified' }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        {{ cutText(customer.description, 40) || 'Role not specified' }}
                                    </p>
                                </div>
                            </div>

                            <span
                                class="badge badge-outline badge-accent ml-2 dark:bg-gray-800 dark:text-blue-400">
                                {{ customer.works?.length || work.data?.length }} works
                            </span>
                        </div>
                        </Link>
                    </div>
                </div>
            </section>
        </div>
        <div v-if="tab != null " class="flex items-center mt-4 gap-x-3">
            <Link :href="route('work.create', customer.id)">
            <button
                class=" btn btn-accent flex items-center justify-end text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Add work</span>
            </button>
            </Link>
        </div>
        <div v-else class="flex-1">
            <section class="container px-4 mx-auto">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div>
                        <div class="flex items-center gap-x-3">
                            <div class="flex items-center">
                                <div class="w-16 h-16 rounded-lg shadow-md overflow-hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true" class="h-16 w-16 mx-auto">
                                        <path fill-rule="evenodd"
                                            d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 01-.517.608 7.45 7.45 0 00-.478.198.798.798 0 01-.796-.064l-.453-.324a1.875 1.875 0 00-2.416.2l-.243.243a1.875 1.875 0 00-.2 2.416l.324.453a.798.798 0 01.064.796 7.448 7.448 0 00-.198.478.798.798 0 01-.608.517l-.55.092a1.875 1.875 0 00-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 01-.064.796l-.324.453a1.875 1.875 0 00.2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 01.796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 01.517-.608 7.52 7.52 0 00.478-.198.798.798 0 01.796.064l.453.324a1.875 1.875 0 002.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 01-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 001.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 01-.608-.517 7.507 7.507 0 00-.198-.478.798.798 0 01.064-.796l.324-.453a1.875 1.875 0 00-.2-2.416l-.243-.243a1.875 1.875 0 00-2.416-.2l-.453.324a.798.798 0 01-.796.064 7.462 7.462 0 00-.478-.198.798.798 0 01-.517-.608l-.091-.55a1.875 1.875 0 00-1.85-1.566h-.344zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-4 text-left">
                                    <h2 class="text-sm font-bold text-gray-800">
                                        {{ work.type }}
                                    </h2>
                                    <p class="text-xs text-gray-600">
                                        {{ work.number }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        {{ work.category }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        {{ work.work_date }}
                                    </p>
                                </div>
                            </div>
                            <span
                                class="badge badge-outline badge-danger text-green-600 bg-green-100 dark:bg-gray-800 dark:text-blue-400">
                                {{ work.cost }} $
                            </span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
