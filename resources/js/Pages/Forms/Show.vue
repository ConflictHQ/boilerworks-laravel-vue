<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';

defineProps<{
    form: {
        uuid: string;
        name: string;
        slug: string;
        description: string | null;
        status: string;
        schema: {
            fields: Array<{ name: string; label: string; type: string; required?: boolean }>;
        };
        submissions_count: number;
        creator: { name: string } | null;
        created_at: string;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this form?')) {
        router.delete(`/forms/${uuid}`);
    }
}
</script>

<template>
    <Head :title="form.name" />
    <AppLayout>
        <div class="mb-6">
            <Link href="/forms" class="text-sm text-gray-400 hover:text-white">
                &larr; Back to Forms
            </Link>
            <div class="mt-2 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-white">
                    {{ form.name }}
                </h1>
                <div class="flex gap-2">
                    <Can permission="forms.submit">
                        <Link
                            v-if="form.status === 'published'"
                            :href="`/forms/${form.uuid}/submit`"
                            class="rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-green-600"
                        >
                            Fill Out
                        </Link>
                    </Can>
                    <Link
                        :href="`/forms/${form.uuid}/submissions`"
                        class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
                    >
                        Submissions ({{ form.submissions_count }})
                    </Link>
                    <Can permission="forms.edit">
                        <Link
                            :href="`/forms/${form.uuid}/edit`"
                            class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
                        >
                            Edit
                        </Link>
                    </Can>
                    <Can permission="forms.delete">
                        <button
                            class="rounded-md border border-red-800 px-4 py-2 text-sm font-medium text-red-400 hover:bg-red-900/50"
                            @click="destroy(form.uuid)"
                        >
                            Delete
                        </button>
                    </Can>
                </div>
            </div>
        </div>
        <div class="max-w-2xl space-y-6">
            <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-gray-400">Description</dt>
                        <dd class="mt-1 text-white">
                            {{ form.description || '—' }}
                        </dd>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div>
                            <dt class="text-sm text-gray-400">Status</dt>
                            <dd class="mt-1">
                                <span
                                    class="rounded-full px-2 py-0.5 text-xs font-medium"
                                    :class="{
                                        'bg-green-900/50 text-green-300':
                                            form.status === 'published',
                                        'bg-yellow-900/50 text-yellow-300': form.status === 'draft',
                                        'bg-gray-800 text-gray-400': form.status === 'archived',
                                    }"
                                >
                                    {{ form.status }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-400">Slug</dt>
                            <dd class="mt-1 text-white">
                                {{ form.slug }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-400">Created by</dt>
                            <dd class="mt-1 text-white">
                                {{ form.creator?.name ?? '—' }}
                            </dd>
                        </div>
                    </div>
                </dl>
            </div>
            <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
                <h2 class="mb-4 text-lg font-semibold text-white">
                    Fields ({{ form.schema.fields.length }})
                </h2>
                <div v-if="form.schema.fields.length === 0" class="text-sm text-gray-400">
                    No fields defined yet.
                </div>
                <div v-else class="space-y-2">
                    <div
                        v-for="(field, idx) in form.schema.fields"
                        :key="idx"
                        class="flex items-center gap-3 rounded border border-gray-700 bg-gray-800 px-3 py-2"
                    >
                        <span class="text-xs text-gray-500">{{ idx + 1 }}</span>
                        <span class="text-sm text-white">{{ field.label }}</span>
                        <span class="rounded bg-gray-700 px-1.5 py-0.5 text-xs text-gray-400">{{
                            field.type
                        }}</span>
                        <span v-if="field.required" class="text-xs text-red-400">required</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
