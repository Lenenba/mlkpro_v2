<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    filters: Object,
    routeName: String,
});

const filterForm = useForm({
    name: props.filters.name ?? "",
});


// Fonction de filtrage avec un délai pour éviter des appels excessifs
let filterTimeout;
const autoFilter = (routeName) => {
    if (filterTimeout) {
        clearTimeout(filterTimeout);
    }
    filterTimeout = setTimeout(() => {
        filterForm.get(route(routeName), {
            preserveState: true,
            preserveScroll: true,
        });
    }, 300); // Délai de 300ms pour éviter les appels excessifs
};

// Réinitialiser le formulaire lorsque la recherche est vide
watch(() => filterForm.name, (newValue) => {
    if (!newValue) {
        filterForm.name = "";
        autoFilter(props.routeName);
    }
});

</script>

<template>
    <fieldset>
        <label class="input  flex items-center w-full h-12 focus:outline-none focus:ring-0">
            <input
                type="text"
                class="grow text-lg p-4 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-0 "
                placeholder="Search"
                v-model="filterForm.name"
                @input="filterForm.name.length >= 1  ? autoFilter(routeName) : null"
            />
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-8 w-8 text-gray-500"
            >
                <path
                    fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd"
                />
            </svg>
        </label>
    </fieldset>
</template>
