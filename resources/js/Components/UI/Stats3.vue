<script setup>
defineProps({
    stats: {
        type: Array,
        default: () => [
            {
                title: "Downloads",
                value: "31K",
                description: "Jan 1st - Feb 1st",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            },
            {
                title: "New Users",
                value: "4,200",
                description: "↗︎ 400 (22%)",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>`,
            },
            {
                title: "New Registers",
                value: "1,200",
                description: "↘︎ 90 (14%)",
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>`,
            },
        ],
    },
});
</script>

<template>
    <div class="stats shadow bg-white">
        <!-- Boucle sur les données -->
        <div v-for="(stat, index) in stats" :key="index" class="stat">
            <div class="stat-figure text-accent" v-html="stat.icon"></div>
            <div class="stat-title">{{ stat.title }}</div>
            <div class="stat-value">{{ stat.value }}</div>
            <div class="stat-desc">{{ stat.description }}</div>
        </div>
    </div>
</template>
