<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';

defineProps<{
    product: {
        uuid: string;
        name: string;
        description: string | null;
        price: string;
        status: string;
        category: { name: string } | null;
        creator: { name: string } | null;
        created_at: string;
        updated_at: string;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this product?')) {
        router.delete(`/products/${uuid}`);
    }
}
</script>

<template>
  <Head :title="product.name" />
  <AppLayout>
    <div class="mb-6">
      <Link
        href="/products"
        class="text-sm text-gray-400 hover:text-white"
      >
        &larr; Back to Products
      </Link>
      <div class="mt-2 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">
          {{ product.name }}
        </h1>
        <div class="flex gap-2">
          <Can permission="products.edit">
            <Link
              :href="`/products/${product.uuid}/edit`"
              class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
            >
              Edit
            </Link>
          </Can>
          <Can permission="products.delete">
            <button
              class="rounded-md border border-red-800 px-4 py-2 text-sm font-medium text-red-400 hover:bg-red-900/50"
              @click="destroy(product.uuid)"
            >
              Delete
            </button>
          </Can>
        </div>
      </div>
    </div>
    <div class="max-w-2xl rounded-lg border border-gray-800 bg-gray-900 p-6">
      <dl class="space-y-4">
        <div>
          <dt class="text-sm text-gray-400">
            Description
          </dt>
          <dd class="mt-1 text-white">
            {{ product.description || '—' }}
          </dd>
        </div>
        <div class="grid gap-4 sm:grid-cols-3">
          <div>
            <dt class="text-sm text-gray-400">
              Price
            </dt>
            <dd class="mt-1 text-white">
              ${{ product.price }}
            </dd>
          </div>
          <div>
            <dt class="text-sm text-gray-400">
              Status
            </dt>
            <dd class="mt-1">
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
            </dd>
          </div>
          <div>
            <dt class="text-sm text-gray-400">
              Category
            </dt>
            <dd class="mt-1 text-white">
              {{ product.category?.name ?? '—' }}
            </dd>
          </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm text-gray-400">
              Created by
            </dt>
            <dd class="mt-1 text-white">
              {{ product.creator?.name ?? '—' }}
            </dd>
          </div>
          <div>
            <dt class="text-sm text-gray-400">
              Created at
            </dt>
            <dd class="mt-1 text-white">
              {{ new Date(product.created_at).toLocaleString() }}
            </dd>
          </div>
        </div>
      </dl>
    </div>
  </AppLayout>
</template>
