<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    forms: {
        data: Array<{
            uuid: string;
            name: string;
            slug: string;
            status: string;
            submissions_count: number;
            created_at: string;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this form?')) {
        router.delete(`/forms/${uuid}`);
    }
}
</script>

<template>
    <Head title="Forms" />
    <AppLayout>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Forms</h1>
            <Can permission="forms.create">
                <Link
                    href="/forms/create"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                >
                    New Form
                </Link>
            </Can>
        </div>
        <div class="overflow-hidden rounded-lg border border-gray-800">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-800 bg-gray-900 text-gray-400">
                    <tr>
                        <th class="px-4 py-3 font-medium">Name</th>
                        <th class="px-4 py-3 font-medium">Slug</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Submissions</th>
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr
                        v-for="form in forms.data"
                        :key="form.uuid"
                        class="bg-gray-950 hover:bg-gray-900"
                    >
                        <td class="px-4 py-3">
                            <Link
                                :href="`/forms/${form.uuid}`"
                                class="text-indigo-400 hover:text-indigo-300"
                            >
                                {{ form.name }}
                            </Link>
                        </td>
                        <td class="px-4 py-3 text-gray-400">
                            {{ form.slug }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="rounded-full px-2 py-0.5 text-xs font-medium"
                                :class="{
                                    'bg-green-900/50 text-green-300': form.status === 'published',
                                    'bg-yellow-900/50 text-yellow-300': form.status === 'draft',
                                    'bg-gray-800 text-gray-400': form.status === 'archived',
                                }"
                            >
                                {{ form.status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-300">
                            {{ form.submissions_count }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <Can permission="forms.edit">
                                    <Link
                                        :href="`/forms/${form.uuid}/edit`"
                                        class="text-sm text-gray-400 hover:text-white"
                                    >
                                        Edit
                                    </Link>
                                </Can>
                                <Can permission="forms.delete">
                                    <button
                                        class="text-sm text-red-400 hover:text-red-300"
                                        @click="destroy(form.uuid)"
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
            <Pagination :links="forms.links" />
        </div>
    </AppLayout>
</template>
