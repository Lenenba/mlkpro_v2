<script setup>
import { ref } from 'vue';

const props = defineProps({
    modelValue: [File, String], // Accepts a file object or a URL
    accept: {
        type: String,
        default: '.jpg,.jpeg,.png,.svg', // Default accepted file types
    },
    label: {
        type: String,
        default: 'Upload Image',
    },
});

const emit = defineEmits(['update:modelValue', 'file-selected', 'file-removed']);

const imageUrl = ref(typeof props.modelValue === 'string' ? props.modelValue : '');
const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        emit('update:modelValue', file);
        emit('file-selected', file);
        imageUrl.value = URL.createObjectURL(file);
    }
};

const removeFile = () => {
    emit('update:modelValue', null);
    emit('file-removed');
    imageUrl.value = '';
};

const getProductImage = (image) => {
    if (!image) return '/images/default-product.png'; // Image par défaut si aucune n'est fournie
    return image.startsWith('http') ? image : `/storage/${image}`;
};
</script>

<template>
    <div class="flex items-center gap-4">
        <!-- Image Preview -->
        <div v-if="imageUrl" class="relative w-50 h-50">
            <img :src="getProductImage(imageUrl)" alt="Preview" class="object-cover w-full h-full rounded-md border border-gray-300" />
        </div>
        <div v-else class="w-40 h-40 flex items-center justify-center bg-gray-100 rounded-md border border-gray-300">
            <span class="text-gray-400 text-sm">No Image</span>
        </div>

        <!-- Upload and Remove Buttons -->
        <div class="flex flex-col gap-2">
            <label
                class="flex items-center px-2 py-2 bg-black text-white text-sm font-medium rounded-md cursor-pointer hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6 mr-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 7.5l4.5-4.5m0 0l4.5 4.5M12 3v13.5" />
                </svg>
                {{ label }}
                <input type="file" :accept="accept" class="hidden" @change="handleFileChange" />
            </label>
            <button v-if="imageUrl" @click.prevent="removeFile" type="button" class="btn btn-neutral">
                Remove
            </button>
        </div>
    </div>
</template>
