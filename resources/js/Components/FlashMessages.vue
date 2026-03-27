<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const flash = computed(() => page.props.flash as { success?: string; error?: string });
</script>

<template>
  <div
    v-if="flash.success"
    class="mb-4 rounded-md border border-green-800 bg-green-900/50 px-4 py-3 text-sm text-green-300"
  >
    {{ flash.success }}
  </div>
  <div
    v-if="flash.error"
    class="mb-4 rounded-md border border-red-800 bg-red-900/50 px-4 py-3 text-sm text-red-300"
  >
    {{ flash.error }}
  </div>
</template>
