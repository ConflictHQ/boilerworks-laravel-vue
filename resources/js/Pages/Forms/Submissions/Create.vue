<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DynamicForm from '@/Components/DynamicForm.vue';

defineProps<{
    form: {
        uuid: string;
        name: string;
        description: string | null;
        schema: {
            fields: Array<{
                name: string;
                label: string;
                type: string;
                required?: boolean;
                placeholder?: string;
                default?: string | number | boolean | null;
                options?: Array<{ label: string; value: string }>;
            }>;
        };
    };
}>();
</script>

<template>
  <Head :title="`Submit ${form.name}`" />
  <AppLayout>
    <div class="mb-6">
      <Link
        :href="`/forms/${form.uuid}`"
        class="text-sm text-gray-400 hover:text-white"
      >
        &larr; Back to {{ form.name }}
      </Link>
      <h1 class="mt-2 text-2xl font-bold text-white">
        {{ form.name }}
      </h1>
      <p
        v-if="form.description"
        class="mt-1 text-gray-400"
      >
        {{ form.description }}
      </p>
    </div>
    <div class="max-w-2xl rounded-lg border border-gray-800 bg-gray-900 p-6">
      <DynamicForm
        :schema="form.schema"
        :submit-url="`/forms/${form.uuid}/submit`"
      />
    </div>
  </AppLayout>
</template>
