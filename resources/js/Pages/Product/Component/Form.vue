<script setup>
import ImageInput from '@/Components/UI/InputImage.vue';
import InputError from '@/Components/InputError.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    product: Object,
});

// Initialize the form
const form = useForm({
    name: props.product?.name || '',
    category_id: props.product?.category_id || '',
    stock: props.product?.stock || 0,
    minimum_stock: props.product?.minimum_stock || 0,
    description: props.product?.description || '',
    image: props.product?.image || '',
});

// Function to handle form submission
const submit = () => {

    const routeName = props.product?.id ? 'product.update' : 'product.store';
    const routeParams = props.product?.id ? props.product.id : undefined;

    form[props.product?.id ? 'put' : 'post'](route(routeName, routeParams), {
        onSuccess: () => {
            console.log('Product saved successfully!');
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
                <label class="input input-bordered flex items-center gap-2 focus:outline-none focus:ring-0">
                    <input type="text" class="grow" placeholder="Name" v-model="form.name" />
                </label>
                <InputError class="mt-2" :message="form.errors.name" />
                <select class="select select-bordered flex items-center gap-2 focus:outline-none focus:ring-0"
                    v-model="form.category_id">
                    <option disabled selected>Select category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <div class="flex flex-row gap-4">
                <label class="input input-bordered flex items-center gap-2 focus:outline-none focus:ring-0">
                    <input type="number" class="grow" placeholder="Stock" v-model="form.stock" />
                </label>
                <label class="input input-bordered flex items-center gap-2 focus:outline-none focus:ring-0">
                    <input type="number" class="grow" placeholder="Minimun stock" v-model="form.minimum_stock" />
                </label>
            </div>

            <textarea class="textarea textarea-bordered w-full" placeholder="Description"
                v-model="form.description"></textarea>
                <p class="validator-hint">Required</p>
            <!-- Images -->
            <div class="mt-1">
                <label for="image" value="Image" />
                <ImageInput v-model="form.image" :model-value="form.image" :label="'Upload'" />
            </div>

            <div class="flex flex-row gap-4 mt-6 mx-auto items-end">
                <Link :href="route('product.index')">
                <button @click="Cancel" class="btn btn-info-content">Cancel</button>
                </Link>
                <button @click="Submit" class="btn btn-primary">Save product</button>
            </div>
        </form>
    </div>
</template>
