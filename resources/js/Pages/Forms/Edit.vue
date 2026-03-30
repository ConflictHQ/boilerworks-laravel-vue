<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormBuilder from '@/Components/FormBuilder.vue';

const props = defineProps<{
    form: {
        uuid: string;
        name: string;
        slug: string;
        description: string | null;
        status: string;
        schema: {
            fields: Array<{
                name: string;
                label: string;
                type: string;
                required: boolean;
                placeholder: string;
                options: Array<{ label: string; value: string }>;
            }>;
        };
    };
}>();

const formData = useForm({
    name: props.form.name,
    slug: props.form.slug,
    description: props.form.description ?? '',
    status: props.form.status,
    schema: props.form.schema,
});

function submit() {
    formData.put(`/forms/${props.form.uuid}`);
}
</script>

<template>
    <Head :title="`Edit ${form.name}`" />
    <AppLayout>
        <div class="mb-6">
            <Link :href="`/forms/${form.uuid}`" class="text-sm text-gray-400 hover:text-white">
                &larr; Back to {{ form.name }}
            </Link>
            <h1 class="mt-2 text-2xl font-bold text-white">Edit Form</h1>
        </div>
        <form class="max-w-3xl space-y-6" @submit.prevent="submit">
            <div class="space-y-6 rounded-lg border border-gray-800 bg-gray-900 p-6">
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-gray-300"
                            >Name</label
                        >
                        <input
                            id="name"
                            v-model="formData.name"
                            type="text"
                            required
                            class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        />
                    </div>
                    <div>
                        <label for="slug" class="mb-1 block text-sm font-medium text-gray-300"
                            >Slug</label
                        >
                        <input
                            id="slug"
                            v-model="formData.slug"
                            type="text"
                            required
                            class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        />
                    </div>
                </div>
                <div>
                    <label for="description" class="mb-1 block text-sm font-medium text-gray-300"
                        >Description</label
                    >
                    <textarea
                        id="description"
                        v-model="formData.description"
                        rows="2"
                        class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    />
                </div>
                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-gray-300"
                        >Status</label
                    >
                    <select
                        id="status"
                        v-model="formData.status"
                        class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    >
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
            </div>

            <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
                <h2 class="mb-4 text-lg font-semibold text-white">Fields</h2>
                <FormBuilder v-model="formData.schema" />
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    :disabled="formData.processing"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
                >
                    Update Form
                </button>
                <Link
                    :href="`/forms/${form.uuid}`"
                    class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
                >
                    Cancel
                </Link>
            </div>
        </form>
    </AppLayout>
</template>
