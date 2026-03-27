<script setup lang="ts">
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import FlashMessages from '@/Components/FlashMessages.vue';

const page = usePage();
const user = computed(
    () => (page.props.auth as { user: { name: string; email: string } | null })?.user,
);
const features = computed(
    () => page.props.features as { forms: boolean; workflows: boolean; search: boolean },
);

function logout() {
    router.post('/logout');
}
</script>

<template>
  <div class="flex min-h-screen bg-gray-950">
    <!-- Sidebar -->
    <aside class="flex w-64 flex-col border-r border-gray-800 bg-gray-900">
      <div class="flex h-16 items-center border-b border-gray-800 px-6">
        <Link
          href="/dashboard"
          class="flex items-center gap-3"
        >
          <img
            src="/images/logo-dark.svg"
            alt="Boilerworks"
            class="h-8"
          >
        </Link>
      </div>
      <nav class="flex-1 space-y-1 px-3 py-4">
        <Link
          href="/dashboard"
          class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white"
        >
          Dashboard
        </Link>
        <Link
          href="/products"
          class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white"
        >
          Products
        </Link>
        <Link
          href="/categories"
          class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white"
        >
          Categories
        </Link>
        <Link
          v-if="features.forms"
          href="/forms"
          class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white"
        >
          Forms
        </Link>
        <Link
          v-if="features.workflows"
          href="/workflows"
          class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white"
        >
          Workflows
        </Link>
      </nav>
      <div class="border-t border-gray-800 p-4">
        <div class="flex items-center justify-between">
          <div class="min-w-0">
            <p class="truncate text-sm font-medium text-white">
              {{ user?.name }}
            </p>
            <p class="truncate text-xs text-gray-400">
              {{ user?.email }}
            </p>
          </div>
          <button
            class="ml-2 rounded-md px-2 py-1 text-xs text-gray-400 hover:bg-gray-800 hover:text-white"
            @click="logout"
          >
            Logout
          </button>
        </div>
      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1">
      <div class="mx-auto max-w-7xl px-6 py-8">
        <FlashMessages />
        <slot />
      </div>
    </main>
  </div>
</template>
