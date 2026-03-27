<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Can from '@/Components/Can.vue';

defineProps<{
    workflow: {
        uuid: string;
        name: string;
        description: string | null;
        status: string;
        states: Array<{
            name: string;
            label: string;
            is_initial: boolean;
            is_final: boolean;
            color: string;
        }>;
        transitions: Array<{ from: string; to: string; label: string }>;
        instances_count: number;
        creator: { name: string } | null;
    };
}>();

function destroy(uuid: string) {
    if (confirm('Delete this workflow?')) {
        router.delete(`/workflows/${uuid}`);
    }
}
</script>

<template>
  <Head :title="workflow.name" />
  <AppLayout>
    <div class="mb-6">
      <Link
        href="/workflows"
        class="text-sm text-gray-400 hover:text-white"
      >
        &larr; Back to Workflows
      </Link>
      <div class="mt-2 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">
          {{ workflow.name }}
        </h1>
        <div class="flex gap-2">
          <Link
            :href="`/workflows/${workflow.uuid}/instances`"
            class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
          >
            Instances ({{ workflow.instances_count }})
          </Link>
          <Can permission="workflows.edit">
            <Link
              :href="`/workflows/${workflow.uuid}/edit`"
              class="rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800"
            >
              Edit
            </Link>
          </Can>
          <Can permission="workflows.delete">
            <button
              class="rounded-md border border-red-800 px-4 py-2 text-sm font-medium text-red-400 hover:bg-red-900/50"
              @click="destroy(workflow.uuid)"
            >
              Delete
            </button>
          </Can>
        </div>
      </div>
    </div>
    <div class="max-w-2xl space-y-6">
      <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
        <dl class="space-y-4">
          <div>
            <dt class="text-sm text-gray-400">
              Description
            </dt>
            <dd class="mt-1 text-white">
              {{ workflow.description || '—' }}
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
                  'bg-green-900/50 text-green-300':
                    workflow.status === 'published',
                  'bg-yellow-900/50 text-yellow-300': workflow.status === 'draft',
                  'bg-gray-800 text-gray-400': workflow.status === 'archived',
                }"
              >
                {{ workflow.status }}
              </span>
            </dd>
          </div>
        </dl>
      </div>
      <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
        <h2 class="mb-4 text-lg font-semibold text-white">
          States ({{ workflow.states.length }})
        </h2>
        <div class="flex flex-wrap gap-2">
          <span
            v-for="state in workflow.states"
            :key="state.name"
            class="rounded-full px-3 py-1 text-xs font-medium"
            :class="
              state.is_initial
                ? 'bg-blue-900/50 text-blue-300'
                : state.is_final
                  ? 'bg-purple-900/50 text-purple-300'
                  : 'bg-gray-800 text-gray-300'
            "
          >
            {{ state.label }}
            <span
              v-if="state.is_initial"
              class="ml-1 text-blue-400"
            >(start)</span>
            <span
              v-if="state.is_final"
              class="ml-1 text-purple-400"
            >(end)</span>
          </span>
        </div>
      </div>
      <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
        <h2 class="mb-4 text-lg font-semibold text-white">
          Transitions ({{ workflow.transitions.length }})
        </h2>
        <div class="space-y-2">
          <div
            v-for="(t, idx) in workflow.transitions"
            :key="idx"
            class="flex items-center gap-2 rounded border border-gray-700 bg-gray-800 px-3 py-2 text-sm"
          >
            <span class="text-gray-400">{{ t.from }}</span>
            <span class="text-gray-600">&rarr;</span>
            <span class="text-white">{{ t.to }}</span>
            <span class="ml-auto text-xs text-gray-500">{{ t.label }}</span>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
