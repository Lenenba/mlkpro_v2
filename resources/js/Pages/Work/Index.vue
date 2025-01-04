<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BodyLayoutVue from '@/Layouts/BodyLayout.vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    works: Array, // Les travaux passés depuis le contrôleur Laravel
});

// Map des works pour le format d'événements FullCalendar
const events = props.works.map(work => ({
    id: work.id,        // Identifiant unique du travail
    title: work.title,  // Titre à afficher
    start: work.date,   // Assurez-vous que "date" est au format ISO (YYYY-MM-DD)
}));

const calendarOptions = {
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth', // Affiche la semaine en cours
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'timeGridWeek,dayGridMonth', // Options de vue semaine/mois
    },
    events: events, // Assignation des événements au calendrier
    eventClick(arg) {
        // Redirection vers une page spécifique
        const workId = arg.event.id;
        router.get(`/work/${workId}`); // Adaptez l'URL selon votre configuration
    },
};
</script>

<template>
    <Head title="Works" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Works
            </h2>
        </template>

        <BodyLayoutVue>
            <div class="bg-base-100 p-4 rounded-box shadow-md">
                <FullCalendar :options="calendarOptions"/>
            </div>
        </BodyLayoutVue>
    </AuthenticatedLayout>
</template>
