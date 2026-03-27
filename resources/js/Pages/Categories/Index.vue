<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    categories: {
        data: Array<{
            uuid: string;
            name: string;
            description: string | null;
            products_count: number;
            created_at: string;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this category?')) {
        router.delete(`/categories/${uuid}`);
    }
}
</script>

<template>
  <Head title="Categories" />
  <AppLayout>
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-white">
        Categories
      </h1>
      <Can permission="categories.create">
        <Link
          href="/categories/create"
          class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
        >
          New Category
        </Link>
      </Can>
    </div>
    <div class="overflow-hidden rounded-lg border border-gray-800">
      <table class="w-full text-left text-sm">
        <thead class="border-b border-gray-800 bg-gray-900 text-gray-400">
          <tr>
            <th class="px-4 py-3 font-medium">
              Name
            </th>
            <th class="px-4 py-3 font-medium">
              Description
            </th>
            <th class="px-4 py-3 font-medium">
              Products
            </th>
            <th class="px-4 py-3 font-medium">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
          <tr
            v-for="category in categories.data"
            :key="category.uuid"
            class="bg-gray-950 hover:bg-gray-900"
          >
            <td class="px-4 py-3">
              <Link
                :href="`/categories/${category.uuid}`"
                class="text-indigo-400 hover:text-indigo-300"
              >
                {{ category.name }}
              </Link>
            </td>
            <td class="max-w-xs truncate px-4 py-3 text-gray-400">
              {{ category.description ?? '—' }}
            </td>
            <td class="px-4 py-3 text-gray-300">
              {{ category.products_count }}
            </td>
            <td class="px-4 py-3">
              <div class="flex gap-2">
                <Can permission="categories.edit">
                  <Link
                    :href="`/categories/${category.uuid}/edit`"
                    class="text-sm text-gray-400 hover:text-white"
                  >
                    Edit
                  </Link>
                </Can>
                <Can permission="categories.delete">
                  <button
                    class="text-sm text-red-400 hover:text-red-300"
                    @click="destroy(category.uuid)"
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
      <Pagination :links="categories.links" />
    </div>
  </AppLayout>
</template>
