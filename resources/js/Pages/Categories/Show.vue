<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';

defineProps<{
    category: {
        uuid: string;
        name: string;
        description: string | null;
        items_count: number;
        creator: { name: string } | null;
        created_at: string;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this category?')) {
        router.delete(`/categories/${uuid}`);
    }
}
</script>

<template>
    <Head :title="category.name" />
    <AppLayout>
        <div class="mb-6">
            <Link href="/categories" class="text-sm text-gray-400 hover:text-white">
                &larr; Back to Categories
            </Link>
            <div class="mt-2 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-white">
                    {{ category.name }}
                </h1>
                <div class="flex gap-2">
                    <Can permission="categories.edit">
                        <Link
                            :href="`/categories/${category.uuid}/edit`"
                            class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
                        >
                            Edit
                        </Link>
                    </Can>
                    <Can permission="categories.delete">
                        <button
                            class="rounded-md border border-red-800 px-4 py-2 text-sm font-medium text-red-400 hover:bg-red-900/50"
                            @click="destroy(category.uuid)"
                        >
                            Delete
                        </button>
                    </Can>
                </div>
            </div>
        </div>
        <div class="max-w-2xl rounded-lg border border-gray-800 bg-gray-900 p-6">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm text-gray-400">Description</dt>
                    <dd class="mt-1 text-white">
                        {{ category.description || '—' }}
                    </dd>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm text-gray-400">Items</dt>
                        <dd class="mt-1 text-white">
                            {{ category.items_count }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-400">Created by</dt>
                        <dd class="mt-1 text-white">
                            {{ category.creator?.name ?? '—' }}
                        </dd>
                    </div>
                </div>
            </dl>
        </div>
    </AppLayout>
</template>
