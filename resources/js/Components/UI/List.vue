<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    type: String,
    items: {
        type: Array,
        default: () => [
            {
                id: 1,
                rank: "01",
                name: "Dio Lupa",
                description: "Remaining Reason",
                image: " ",
            },
        ],
    },
});
</script>

<template>
    <ul class="list bg-base-100 rounded-box shadow-md">
        <!-- Titre dynamique via slot -->
        <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">
            <slot name="Title">Default Title</slot>
        </li>

        <!-- Liste dynamique -->
        <li v-for="(item, index) in items" :key="index"
            class="list-row flex items-center gap-4 p-4 border-b border-base-200">
            <div class="text-4xl font-thin opacity-30 tabular-nums">{{ item.rank }}</div>
            <div>
                <img v-if="item.image" :src="`/storage/${item.image}`" :alt="item.name || 'Item image'" class="size-10 rounded-box" />
                <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                    class="h-9 w-9 mx-auto">
                    <path fill-rule="evenodd"
                        d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 01-.517.608 7.45 7.45 0 00-.478.198.798.798 0 01-.796-.064l-.453-.324a1.875 1.875 0 00-2.416.2l-.243.243a1.875 1.875 0 00-.2 2.416l.324.453a.798.798 0 01.064.796 7.448 7.448 0 00-.198.478.798.798 0 01-.608.517l-.55.092a1.875 1.875 0 00-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 01-.064.796l-.324.453a1.875 1.875 0 00.2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 01.796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 01.517-.608 7.52 7.52 0 00.478-.198.798.798 0 01.796.064l.453.324a1.875 1.875 0 002.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 01-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 001.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 01-.608-.517 7.507 7.507 0 00-.198-.478.798.798 0 01.064-.796l.324-.453a1.875 1.875 0 00-.2-2.416l-.243-.243a1.875 1.875 0 00-2.416-.2l-.453.324a.798.798 0 01-.796.064 7.462 7.462 0 00-.478-.198.798.798 0 01-.517-.608l-.091-.55a1.875 1.875 0 00-1.85-1.566h-.344zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>

            <div class="list-col-grow">
                <div class="font-medium">{{ item.name }}</div>
                <div class="text-xs uppercase font-semibold opacity-60">{{ item.description }}</div>
            </div>
            <Link :href="route(type, item.id)">
            <button class="btn btn-square btn-ghost">
                <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none"
                        stroke="currentColor">
                        <path d="M6 3L20 12 6 21 6 3z"></path>
                    </g>
                </svg>
            </button>
            </Link>
        </li>
    </ul>
</template>
