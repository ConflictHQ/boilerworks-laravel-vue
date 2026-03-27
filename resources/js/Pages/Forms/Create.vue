<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormBuilder from '@/Components/FormBuilder.vue';

const form = useForm({
    name: '',
    slug: '',
    description: '',
    status: 'draft',
    schema: { fields: [] as Array<{ name: string; label: string; type: string; required: boolean; placeholder: string; options: Array<{ label: string; value: string }> }> },
});

function generateSlug() {
    form.slug = form.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
}

function submit() {
    form.post('/forms');
}
</script>

<template>
  <Head title="New Form" />
  <AppLayout>
    <div class="mb-6">
      <Link
        href="/forms"
        class="text-sm text-gray-400 hover:text-white"
      >
        &larr; Back to Forms
      </Link>
      <h1 class="mt-2 text-2xl font-bold text-white">
        New Form
      </h1>
    </div>
    <form
      class="max-w-3xl space-y-6"
      @submit.prevent="submit"
    >
      <div class="space-y-6 rounded-lg border border-gray-800 bg-gray-900 p-6">
        <div class="grid gap-6 sm:grid-cols-2">
          <div>
            <label
              for="name"
              class="mb-1 block text-sm font-medium text-gray-300"
            >Name</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
              @blur="generateSlug"
            >
            <p
              v-if="form.errors.name"
              class="mt-1 text-sm text-red-400"
            >
              {{ form.errors.name }}
            </p>
          </div>
          <div>
            <label
              for="slug"
              class="mb-1 block text-sm font-medium text-gray-300"
            >Slug</label>
            <input
              id="slug"
              v-model="form.slug"
              type="text"
              required
              class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            >
            <p
              v-if="form.errors.slug"
              class="mt-1 text-sm text-red-400"
            >
              {{ form.errors.slug }}
            </p>
          </div>
        </div>
        <div>
          <label
            for="description"
            class="mb-1 block text-sm font-medium text-gray-300"
          >Description</label>
          <textarea
            id="description"
            v-model="form.description"
            rows="2"
            class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
          />
        </div>
        <div>
          <label
            for="status"
            class="mb-1 block text-sm font-medium text-gray-300"
          >Status</label>
          <select
            id="status"
            v-model="form.status"
            class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
          >
            <option value="draft">
              Draft
            </option>
            <option value="published">
              Published
            </option>
            <option value="archived">
              Archived
            </option>
          </select>
        </div>
      </div>

      <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
        <h2 class="mb-4 text-lg font-semibold text-white">
          Fields
        </h2>
        <FormBuilder v-model="form.schema" />
      </div>

      <div class="flex gap-3">
        <button
          type="submit"
          :disabled="form.processing"
          class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
        >
          Create Form
        </button>
        <Link
          href="/forms"
          class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
        >
          Cancel
        </Link>
      </div>
    </form>
  </AppLayout>
</template>
