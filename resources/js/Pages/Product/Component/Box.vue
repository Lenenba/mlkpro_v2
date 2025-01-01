<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    item: {
        type: Object, // Remplacez `object` par `Object`
        default: () => ({ // Utilisez une fonction pour retourner un objet par défaut
            id: 1,
            name: "Dio Lupa",
            description: "Remaining Reason",
            category: "Utility",
            stock: 10,
            image: "https://img.daisyui.com/images/profile/demo/1@94.webp",
        }),
    },
    routeName: {
        type: String,
        default: "product.show",
    },

});

const cutText = (text, length) => {
    return text.length > length ? text.substring(0, length) + '...' : text;
};

</script>

<template>
    <Link :href="route(routeName, item.id)">
    <div className="card bg-base-100 w-96 shadow-sm mx-auto">
        <figure>
            <img :src="item.image" :alt="item.name" />
        </figure>
        <div className="card-body">
            <h2 className="card-title">
                {{ item.name }}
                <!-- <div className="badge badge-secondary">NEW</div> -->
            </h2>
            <p className="text-sm text-gray-700 overflow-hidden">
                {{ cutText(item.description, 45) }}
            </p>
            <div className="card-actions justify-end mt-2">
                <button class="btn">
                    Category :<div class="badge badge-soft badge-neutral">{{ item.category.name }}</div>
                </button>
                <button class="btn">
                    Stock :<div class="badge badge-soft badge-accent">{{ item.stock }}</div>
                </button>
            </div>
        </div>
    </div>
    </Link>
</template>
