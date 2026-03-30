<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    form: {
        uuid: string;
        name: string;
        schema: { fields: Array<{ name: string; label: string }> };
    };
    submissions: {
        data: Array<{
            uuid: string;
            data: Record<string, unknown>;
            created_at: string;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
}>();
</script>

<template>
    <Head :title="`${form.name} — Submissions`" />
    <AppLayout>
        <div class="mb-6">
            <Link :href="`/forms/${form.uuid}`" class="text-sm text-gray-400 hover:text-white">
                &larr; Back to {{ form.name }}
            </Link>
            <h1 class="mt-2 text-2xl font-bold text-white">Submissions</h1>
        </div>
        <div class="overflow-hidden rounded-lg border border-gray-800">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-800 bg-gray-900 text-gray-400">
                    <tr>
                        <th class="px-4 py-3 font-medium">#</th>
                        <th
                            v-for="field in form.schema.fields.slice(0, 4)"
                            :key="field.name"
                            class="px-4 py-3 font-medium"
                        >
                            {{ field.label }}
                        </th>
                        <th class="px-4 py-3 font-medium">Submitted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr
                        v-for="(sub, idx) in submissions.data"
                        :key="sub.uuid"
                        class="bg-gray-950 hover:bg-gray-900"
                    >
                        <td class="px-4 py-3 text-gray-500">
                            {{ idx + 1 }}
                        </td>
                        <td
                            v-for="field in form.schema.fields.slice(0, 4)"
                            :key="field.name"
                            class="max-w-xs truncate px-4 py-3 text-gray-300"
                        >
                            {{ sub.data[field.name] ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-gray-400">
                            {{ new Date(sub.created_at).toLocaleString() }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            <Pagination :links="submissions.links" />
        </div>
    </AppLayout>
</template>
