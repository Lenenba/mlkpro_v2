<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    item: {
        type: Object, // Remplacez `object` par `Object`
        default: () => ({ // Utilisez une fonction pour retourner un objet par défaut
            id: 1,
            name: "Dio Lupa",
            number: "c-002",
            company_name: "Remaining Reason",
            address: "Utility",
            phone: 10,
            image: "https://img.daisyui.com/images/profile/demo/1@94.webp",
        }),
    },
    routeName: {
        type: String,
        default: "item.show",
    },
    page: {
        type: String,
        default: 1,
    },

});

const cutText = (text, length) => {
    return text.length > length ? text.substring(0, length) + '...' : text;
};
const getItemImage = (item) => {
    if (!item.logo) return '/images/default-item.png'; // Image par défaut si aucune n'est fournie
    return item.logo.startsWith('http') ? item.logo : `/storage/${item.logo}`;
};
</script>

<template>
    <Link :href="route(routeName, item.id)">
    <div class=" h-32 w-42 card card-side card-xs bg-base-100 shadow-xl flex flex-row items-center">
            <figure class="h-32 w-32">
                <img :src="getItemImage(item)" :alt="item.name" />
            </figure>
            <div class="card-body flex flex-col items-start">
                <h2 class="card-title text-xs">{{ item.name }}</h2>
                <p v-if="page != 'show'" className="text-sm text-gray-700 overflow-hidden">
                    {{ item.description }}
                </p>
                <p v-else className="text-sm text-gray-700 overflow-hidden">
                    {{ cutText(item.description, 30) }}
                </p>
                <div className="card-actions justify-end mt-2">
                    <button class="btn btn-xs">
                        <div class="badge badge-soft badge-accent text-xs">{{ item.number }}</div>
                    </button>
                    <button class="btn btn-xs">
                        <div class="badge badge-soft badge-success text-xs">{{ item.phone }}</div>
                    </button>
                </div>
            </div>
        </div>
    </Link>
</template>
