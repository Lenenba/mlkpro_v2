<script setup>
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    products: Array,
    work: Object,
});

const IsOpenProductDeleteModal = ref(false);

const handleDelete = (product) => {
    Deleteform.product = product;
    IsOpenProductDeleteModal.value = true;
};

const closeModal = () => {
    IsOpenProductDeleteModal.value = false;
};

const Deleteform = useForm({
    product: '',
});

// Fonction pour soumettre le formulaire et supprimer le produit
const deleteProduct = () => {
    Deleteform.delete(route('work.product.detach', { work: props.work, product: Deleteform.product }), {
        onSuccess: () => {
            console.log('Product has been deleted successfully!');
            closeModal();
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        }
    });
};

const cutText = (text, length) => {
    return text.length > length ? text.substring(0, length) + '...' : text;
};


</script>

<template>
    <div class="overflow-x-auto my-20">
        <table class="table table-xs">
            <!-- head -->
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>stock</th>
                    <th>Qty used</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                <tr v-for="product in products" :key="product.id" :value="product.id">
                    <td>{{ product.number }}</td>
                    <td>{{ product.name }} </td>
                    <td>{{ product.category.name }} </td>
                    <td> {{ cutText(product.description, 30) }} </td>
                    <td>{{ product.price }} </td>
                    <td>{{ product.stock }}</td>
                    <th>{{ product.pivot.quantity_used }} - {{ product.pivot.unit }}</th>
                    <th class="px-4 py-2 text-sm whitespace-nowrap">
                        <button @click="handleDelete(product)"
                            class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-red-500 hover:bg-red-500/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-4 w-4">
                                <path fill-rule="evenodd"
                                    d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </th>
                    <Modal :show="IsOpenProductDeleteModal" @close="closeModal">
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Are you sure you want to delete this product?
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Once your product is deleted, all of its resources and data
                                will be permanently deleted. This action cannot be undone.
                            </p>

                            <!-- Erreur d'entrée si nécessaire -->
                            <InputError :message="Deleteform.errors.productId" class="mt-4" />

                            <div class="mt-6 flex justify-end">
                                <!-- Bouton d'annulation -->
                                <button class="btn btn-secondary" @click="closeModal">
                                    Cancel
                                </button>

                                <!-- Bouton de suppression -->
                                <button class="btn btn-danger ms-3" :disabled="Deleteform.processing"
                                    @click="deleteProduct">
                                    Delete Product
                                </button>
                            </div>
                        </div>
                    </Modal>
                </tr>
            </tbody>
        </table>
    </div>
</template>
