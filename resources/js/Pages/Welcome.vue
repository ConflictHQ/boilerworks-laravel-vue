<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Welcome" />
  <div class="flex min-h-screen items-center justify-center bg-gray-950">
    <div class="text-center">
      <img
        src="/images/logo-dark.svg"
        alt="Boilerworks"
        class="mx-auto mb-8 h-16"
      >
      <h1 class="mb-4 text-4xl font-bold text-white">
        Boilerworks
      </h1>
      <p class="text-lg text-gray-400">
        Laravel + Vue template is running.
      </p>
    </div>
  </div>
</template>
