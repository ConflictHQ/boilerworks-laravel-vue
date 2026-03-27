<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const form = useForm({
    name: '',
    description: '',
});

function submit() {
    form.post('/categories');
}
</script>

<template>
  <Head title="New Category" />
  <AppLayout>
    <div class="mb-6">
      <Link
        href="/categories"
        class="text-sm text-gray-400 hover:text-white"
      >
        &larr; Back to Categories
      </Link>
      <h1 class="mt-2 text-2xl font-bold text-white">
        New Category
      </h1>
    </div>
    <form
      class="max-w-2xl space-y-6 rounded-lg border border-gray-800 bg-gray-900 p-6"
      @submit.prevent="submit"
    >
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
          for="description"
          class="mb-1 block text-sm font-medium text-gray-300"
        >Description</label>
        <textarea
          id="description"
          v-model="form.description"
          rows="3"
          class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
        />
      </div>
      <div class="flex gap-3">
        <button
          type="submit"
          :disabled="form.processing"
          class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
        >
          Create Category
        </button>
        <Link
          href="/categories"
          class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
        >
          Cancel
        </Link>
      </div>
    </form>
  </AppLayout>
</template>
