<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    items: {
        data: Array<{
            uuid: string;
            name: string;
            price: string;
            status: string;
            category: { name: string } | null;
            created_at: string;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this item?')) {
        router.delete(`/items/${uuid}`);
    }
}
</script>

<template>
    <Head title="Items" />
    <AppLayout>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Items</h1>
            <Can permission="items.create">
                <Link
                    href="/items/create"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                >
                    New Item
                </Link>
            </Can>
        </div>
        <div class="overflow-hidden rounded-lg border border-gray-800">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-800 bg-gray-900 text-gray-400">
                    <tr>
                        <th class="px-4 py-3 font-medium">Name</th>
                        <th class="px-4 py-3 font-medium">Category</th>
                        <th class="px-4 py-3 font-medium">Price</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr
                        v-for="item in items.data"
                        :key="item.uuid"
                        class="bg-gray-950 hover:bg-gray-900"
                    >
                        <td class="px-4 py-3">
                            <Link
                                :href="`/items/${item.uuid}`"
                                class="text-indigo-400 hover:text-indigo-300"
                            >
                                {{ item.name }}
                            </Link>
                        </td>
                        <td class="px-4 py-3 text-gray-400">
                            {{ item.category?.name ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-gray-300">${{ item.price }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="rounded-full px-2 py-0.5 text-xs font-medium"
                                :class="{
                                    'bg-green-900/50 text-green-300': item.status === 'active',
                                    'bg-yellow-900/50 text-yellow-300': item.status === 'draft',
                                    'bg-gray-800 text-gray-400': item.status === 'archived',
                                }"
                            >
                                {{ item.status }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <Can permission="items.edit">
                                    <Link
                                        :href="`/items/${item.uuid}/edit`"
                                        class="text-sm text-gray-400 hover:text-white"
                                    >
                                        Edit
                                    </Link>
                                </Can>
                                <Can permission="items.delete">
                                    <button
                                        class="text-sm text-red-400 hover:text-red-300"
                                        @click="destroy(item.uuid)"
                                    >
                                        Delete
                                    </button>
                                </Can>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            <Pagination :links="items.links" />
        </div>
    </AppLayout>
</template>
