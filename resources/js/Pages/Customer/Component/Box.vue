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
    <div className="card bg-base-100 w-96 shadow-sm mx-auto">
        <figure class="mt-8">
            <img :src="getItemImage(item)" :alt="item.name" />
        </figure>
        <div className="card-body">
            <h2 className="card-title">
                {{ item.name }} - {{ item.number }}
                <!-- <div className="badge badge-secondary">NEW</div> -->
            </h2>
            <p className="text-sm text-gray-700 overflow-hidden">
                {{ item.company_name }}
            </p>

            <p class="text-sm text-gray-700 ">
                {{ cutText(item.address, 30)}}
            </p>
            <div className="card-actions w-full mt-2">
                <button class="btn text-xs">
                    Number :<div class="badge badge-soft badge-neutral">{{ item.number }}</div>
                </button>
            </div>
        </div>
    </div>
    </Link>
</template>
