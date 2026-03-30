<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    workflow: { uuid: string; name: string };
    instances: {
        data: Array<{
            uuid: string;
            current_state: string;
            created_at: string;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
    availableTransitions: Record<string, Array<{ to: string; label: string }>>;
}>();

function transition(workflowUuid: string, instanceUuid: string, toState: string) {
    router.post(`/workflows/${workflowUuid}/instances/${instanceUuid}/transition`, {
        to_state: toState,
    });
}
</script>

<template>
    <Head :title="`${workflow.name} — Instances`" />
    <AppLayout>
        <div class="mb-6">
            <Link
                :href="`/workflows/${workflow.uuid}`"
                class="text-sm text-gray-400 hover:text-white"
            >
                &larr; Back to {{ workflow.name }}
            </Link>
            <div class="mt-2 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-white">Instances</h1>
                <Can permission="workflows.create">
                    <button
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                        @click="router.post(`/workflows/${workflow.uuid}/instances`)"
                    >
                        New Instance
                    </button>
                </Can>
            </div>
        </div>
        <div class="overflow-hidden rounded-lg border border-gray-800">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-800 bg-gray-900 text-gray-400">
                    <tr>
                        <th class="px-4 py-3 font-medium">ID</th>
                        <th class="px-4 py-3 font-medium">Current State</th>
                        <th class="px-4 py-3 font-medium">Created</th>
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr
                        v-for="inst in instances.data"
                        :key="inst.uuid"
                        class="bg-gray-950 hover:bg-gray-900"
                    >
                        <td class="px-4 py-3 font-mono text-xs text-gray-400">
                            {{ inst.uuid.substring(0, 8) }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="rounded-full bg-indigo-900/50 px-2 py-0.5 text-xs font-medium text-indigo-300"
                            >
                                {{ inst.current_state }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-400">
                            {{ new Date(inst.created_at).toLocaleString() }}
                        </td>
                        <td class="px-4 py-3">
                            <Can permission="workflows.transition">
                                <div class="flex gap-1">
                                    <button
                                        v-for="t in availableTransitions[inst.uuid] || []"
                                        :key="t.to"
                                        class="rounded bg-gray-800 px-2 py-1 text-xs text-gray-300 hover:bg-gray-700"
                                        @click="transition(workflow.uuid, inst.uuid, t.to)"
                                    >
                                        {{ t.label }}
                                    </button>
                                </div>
                            </Can>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            <Pagination :links="instances.links" />
        </div>
    </AppLayout>
</template>
