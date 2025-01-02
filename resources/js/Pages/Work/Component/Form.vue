<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    customer: Object,
    work: Object,
});

// Initialize the form
const form = useForm({
    customer_id: props.customer.id,
    description: props.work?.description || '',
    type: props.work?.type || '',
    category: props.work?.category || '',
    work_date: props.work?.work_date || '',
    time_spent: props.work?.time_spent || '',
    base_cost: props.work?.cost || '',
});

const categoryOptions = [
    { value: 'plumbing', label: 'Plumbing' },
    { value: 'electrical', label: 'Electrical' },
    { value: 'carpentry', label: 'Carpentry' },
    { value: 'painting', label: 'Painting' },
    { value: 'cleaning', label: 'Cleaning' },
    { value: 'gardening', label: 'Gardening' },
    { value: 'other', label: 'Other' },
];

const typeOptions = [
    { value: 'repair', label: 'Repair' },
    { value: 'installation', label: 'Installation' },
    { value: 'maintenance', label: 'Maintenance' },
    { value: 'other', label: 'Other' },
];

// Function to handle form submission
const submit = () => {

    console.log('form:', form.data());
    const routeName = props.work?.id ? 'work.update' : 'work.store';
    const routeParams = props.work?.id ? props.work.id : undefined;

    form[props.work?.id ? 'put' : 'post'](route(routeName, routeParams), {
        onSuccess: () => {
            console.log('work saved successfully!');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
</script>

<template>
    <div className="card bg-base-100 w-full shadow-sm mx-auto">
        <form className="card-body" @submit.prevent="submit">
            <div class="flex flex-row gap-4">
                <select class="select flex items-center w-full" v-model="form.category">
                    <option disabled selected>Select category</option>
                    <option v-for="category in categoryOptions" :key="category.value">{{ category.value }}</option>
                </select>
                <select class="select flex items-center w-full" v-model="form.type">
                    <option disabled selected>Select type</option>
                    <option v-for="type in typeOptions" :key="type.value">{{ type.value }}</option>
                </select>
            </div>

             <!-- Row 4: City, State, and Zip -->
             <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <input type="date" placeholder="work date" class="input items-center w-full" v-model="form.work_date" />
                </div>
                <div>
                    <input type="number" class="input validator items-center w-full" required placeholder="Time spent must be 1 to 48" min="1" max="48"
                    title="Must be between be 1 to 10" v-model="form.time_spent" />
                </div>
                <div>
                    <input type="number" class="input validator items-center w-full" required placeholder="Cost must be 1 to 48" min="1" max="2000"
                    title="Must be between be 1 to 10" v-model="form.base_cost" />
                </div>
            </div>
            <textarea class="textarea textarea-bordered w-full" placeholder="Description"
                v-model="form.description"></textarea>

            <div class="flex flex-row gap-4 mt-6 mx-auto items-end">
                <Link :href="route('customer.show', customer.id)">
                <button @click="Cancel" class="btn btn-info-content">Cancel</button>
                </Link>
                <button class="btn btn-primary">Save work</button>
            </div>
        </form>
    </div>
</template>
