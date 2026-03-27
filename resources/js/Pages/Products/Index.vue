<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    products: {
        data: Array<{
            uuid: string;
            name: string;
            price: string;
            status: string;
            category: { name: string } | null;
            created_at: string;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this product?')) {
        router.delete(`/products/${uuid}`);
    }
}
</script>

<template>
  <Head title="Products" />
  <AppLayout>
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-white">
        Products
      </h1>
      <Can permission="products.create">
        <Link
          href="/products/create"
          class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
        >
          New Product
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
              Category
            </th>
            <th class="px-4 py-3 font-medium">
              Price
            </th>
            <th class="px-4 py-3 font-medium">
              Status
            </th>
            <th class="px-4 py-3 font-medium">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
          <tr
            v-for="product in products.data"
            :key="product.uuid"
            class="bg-gray-950 hover:bg-gray-900"
          >
            <td class="px-4 py-3">
              <Link
                :href="`/products/${product.uuid}`"
                class="text-indigo-400 hover:text-indigo-300"
              >
                {{ product.name }}
              </Link>
            </td>
            <td class="px-4 py-3 text-gray-400">
              {{ product.category?.name ?? '—' }}
            </td>
            <td class="px-4 py-3 text-gray-300">
              ${{ product.price }}
            </td>
            <td class="px-4 py-3">
              <span
                class="rounded-full px-2 py-0.5 text-xs font-medium"
                :class="{
                  'bg-green-900/50 text-green-300': product.status === 'active',
                  'bg-yellow-900/50 text-yellow-300': product.status === 'draft',
                  'bg-gray-800 text-gray-400': product.status === 'archived',
                }"
              >
                {{ product.status }}
              </span>
            </td>
            <td class="px-4 py-3">
              <div class="flex gap-2">
                <Can permission="products.edit">
                  <Link
                    :href="`/products/${product.uuid}/edit`"
                    class="text-sm text-gray-400 hover:text-white"
                  >
                    Edit
                  </Link>
                </Can>
                <Can permission="products.delete">
                  <button
                    class="text-sm text-red-400 hover:text-red-300"
                    @click="destroy(product.uuid)"
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
      <Pagination :links="products.links" />
    </div>
  </AppLayout>
</template>
