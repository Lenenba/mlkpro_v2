<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';

const props = defineProps({
    works: Object,
});

</script>

<template>

    <Head title="works" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Works
            </h2>
        </template>

        <BodyLayoutVue>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
