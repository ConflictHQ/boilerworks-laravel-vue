<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps<{
    item: {
        uuid: string;
        name: string;
        description: string | null;
        price: string;
        status: string;
        category_id: number | null;
    };
    categories: Array<{ id: number; uuid: string; name: string }>;
}>();

const form = useForm({
    name: props.item.name,
    description: props.item.description ?? '',
    price: props.item.price,
    status: props.item.status,
    category_id: props.item.category_id ?? ('' as string | number),
});

function submit() {
    form.put(`/items/${props.item.uuid}`);
}
</script>

<template>
    <Head :title="`Edit ${item.name}`" />
    <AppLayout>
        <div class="mb-6">
            <Link :href="`/items/${item.uuid}`" class="text-sm text-gray-400 hover:text-white">
                &larr; Back to {{ item.name }}
            </Link>
            <h1 class="mt-2 text-2xl font-bold text-white">Edit Item</h1>
        </div>
        <form
            class="max-w-2xl space-y-6 rounded-lg border border-gray-800 bg-gray-900 p-6"
            @submit.prevent="submit"
        >
            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-gray-300">Name</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    required
                    class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-400">
                    {{ form.errors.name }}
                </p>
            </div>
            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-gray-300"
                    >Description</label
                >
                <textarea
                    id="description"
                    v-model="form.description"
                    rows="3"
                    class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                />
            </div>
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="price" class="mb-1 block text-sm font-medium text-gray-300"
                        >Price</label
                    >
                    <input
                        id="price"
                        v-model="form.price"
                        type="number"
                        step="0.01"
                        min="0.01"
                        required
                        class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    />
                </div>
                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-gray-300"
                        >Status</label
                    >
                    <select
                        id="status"
                        v-model="form.status"
                        class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    >
                        <option value="active">Active</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="category_id" class="mb-1 block text-sm font-medium text-gray-300"
                    >Category</label
                >
                <select
                    id="category_id"
                    v-model="form.category_id"
                    class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                >
                    <option value="">None</option>
                    <option v-for="cat in categories" :key="cat.uuid" :value="cat.id">
                        {{ cat.name }}
                    </option>
                </select>
            </div>
            <div class="flex gap-3">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
                >
                    Update Item
                </button>
                <Link
                    :href="`/items/${item.uuid}`"
                    class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
                >
                    Cancel
                </Link>
            </div>
        </form>
    </AppLayout>
</template>
