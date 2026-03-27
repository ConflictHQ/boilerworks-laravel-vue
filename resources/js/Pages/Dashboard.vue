<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
  <Head title="Dashboard" />
  <AppLayout>
    <h1 class="mb-6 text-2xl font-bold text-white">
      Dashboard
    </h1>
    <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
      <p class="text-gray-400">
        Welcome to Boilerworks. Use the sidebar to navigate.
      </p>
    </div>
  </AppLayout>
</template>
