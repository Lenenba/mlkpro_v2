<script setup>
import ImageInput from '@/Components/UI/InputImage.vue';
import InputError from '@/Components/InputError.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    customer: Object,
});

// Initialize the form
const form = useForm({
    name: props.customer?.name || '',
    email: props.customer?.email || '',
    phone: props.customer?.phone || '',
    address: props.customer?.address || '',
    city: props.customer?.city || '',
    state: props.customer?.state || '',
    zip: props.customer?.zip || '',
    company_name: props.customer?.company_name || '',
    logo: props.customer?.logo || '',
    type: props.customer?.type || '',
    description: props.customer?.description || '',
});

// Function to handle form submission
const submit = () => {
    const routeName = props.customer?.id ? 'customer.update' : 'customer.store';
    const routeParams = props.customer?.id ? props.customer.id : undefined;

    form[props.customer?.id ? 'put' : 'post'](route(routeName, routeParams), {
        onSuccess: () => {
            console.log('Customer saved successfully!');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
</script>

<template>
    <div class="card bg-base-100 w-full shadow-sm mx-auto">
        <form class="card-body" @submit.prevent="submit">
            <!-- Row 1: Name and Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="Name" v-model="form.name" />
                    </label>
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="Email" v-model="form.email" />
                    </label>
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>
            </div>

            <!-- Row 2: Company Name and Type -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="Company Name" v-model="form.company_name" />
                    </label>
                </div>
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="Type" v-model="form.type" />
                    </label>
                </div>
            </div>

            <!-- Row 3: Address and Phone -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="Address" v-model="form.address" />
                    </label>
                </div>
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="Phone" v-model="form.phone" />
                    </label>
                </div>
            </div>

            <!-- Row 4: City, State, and Zip -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="City" v-model="form.city" />
                    </label>
                </div>
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="State" v-model="form.state" />
                    </label>
                </div>
                <div>
                    <label class="input input-bordered w-full">
                        <input type="text" placeholder="ZIP" v-model="form.zip" />
                    </label>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-4">
                <textarea
                    class="textarea textarea-bordered w-full"
                    placeholder="Description"
                    v-model="form.description"
                ></textarea>
                <p class="text-sm text-gray-500 mt-1">Required</p>
            </div>

            <!-- Image Input -->
            <div class="mt-4">
                <ImageInput v-model="form.logo" :label="'Upload Logo'" />
            </div>

            <!-- Actions -->
            <div class="flex flex-row gap-4 mt-6">
                <Link :href="route('customer.index')" class="btn btn-secondary">Cancel</Link>
                <button type="submit" class="btn btn-primary">Save Customer</button>
            </div>
        </form>
    </div>
</template>
