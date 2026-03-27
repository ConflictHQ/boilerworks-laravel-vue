<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import WorkflowBuilder from '@/Components/WorkflowBuilder.vue';

const props = defineProps<{
    workflow: {
        uuid: string;
        name: string;
        description: string | null;
        status: string;
        states: Array<{ name: string; label: string; is_initial: boolean; is_final: boolean; color: string }>;
        transitions: Array<{ from: string; to: string; label: string; conditions: Array<{ type: string; value: string }>; actions: Array<{ type: string; config: Record<string, string> }> }>;
    };
}>();

const form = useForm({
    name: props.workflow.name,
    description: props.workflow.description ?? '',
    status: props.workflow.status,
    states: props.workflow.states,
    transitions: props.workflow.transitions,
});

function submit() {
    form.put(`/workflows/${props.workflow.uuid}`);
}
</script>

<template>
  <Head :title="`Edit ${workflow.name}`" />
  <AppLayout>
    <div class="mb-6">
      <Link
        :href="`/workflows/${workflow.uuid}`"
        class="text-sm text-gray-400 hover:text-white"
      >
        &larr; Back to {{ workflow.name }}
      </Link>
      <h1 class="mt-2 text-2xl font-bold text-white">
        Edit Workflow
      </h1>
    </div>
    <form
      class="max-w-3xl space-y-6"
      @submit.prevent="submit"
    >
      <div class="space-y-6 rounded-lg border border-gray-800 bg-gray-900 p-6">
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
          States & Transitions
        </h2>
        <WorkflowBuilder
          v-model:states="form.states"
          v-model:transitions="form.transitions"
        />
      </div>

      <div class="flex gap-3">
        <button
          type="submit"
          :disabled="form.processing"
          class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
        >
          Update Workflow
        </button>
        <Link
          :href="`/workflows/${workflow.uuid}`"
          class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
        >
          Cancel
        </Link>
      </div>
    </form>
  </AppLayout>
</template>
