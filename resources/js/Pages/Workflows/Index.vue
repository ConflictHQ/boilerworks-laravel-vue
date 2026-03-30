<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    workflows: {
        data: Array<{
            uuid: string;
            name: string;
            status: string;
            instances_count: number;
            created_at: string;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this workflow?')) {
        router.delete(`/workflows/${uuid}`);
    }
}
</script>

<template>
    <Head title="Workflows" />
    <AppLayout>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Workflows</h1>
            <Can permission="workflows.create">
                <Link
                    href="/workflows/create"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                >
                    New Workflow
                </Link>
            </Can>
        </div>
        <div class="overflow-hidden rounded-lg border border-gray-800">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-800 bg-gray-900 text-gray-400">
                    <tr>
                        <th class="px-4 py-3 font-medium">Name</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Instances</th>
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr
                        v-for="wf in workflows.data"
                        :key="wf.uuid"
                        class="bg-gray-950 hover:bg-gray-900"
                    >
                        <td class="px-4 py-3">
                            <Link
                                :href="`/workflows/${wf.uuid}`"
                                class="text-indigo-400 hover:text-indigo-300"
                            >
                                {{ wf.name }}
                            </Link>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="rounded-full px-2 py-0.5 text-xs font-medium"
                                :class="{
                                    'bg-green-900/50 text-green-300': wf.status === 'published',
                                    'bg-yellow-900/50 text-yellow-300': wf.status === 'draft',
                                    'bg-gray-800 text-gray-400': wf.status === 'archived',
                                }"
                            >
                                {{ wf.status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-300">
                            {{ wf.instances_count }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <Can permission="workflows.edit">
                                    <Link
                                        :href="`/workflows/${wf.uuid}/edit`"
                                        class="text-sm text-gray-400 hover:text-white"
                                    >
                                        Edit
                                    </Link>
                                </Can>
                                <Can permission="workflows.delete">
                                    <button
                                        class="text-sm text-red-400 hover:text-red-300"
                                        @click="destroy(wf.uuid)"
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
            <Pagination :links="workflows.links" />
        </div>
    </AppLayout>
</template>
