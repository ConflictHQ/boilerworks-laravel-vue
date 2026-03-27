<script setup lang="ts">
import { ref, computed } from 'vue';

interface StateDef {
    name: string;
    label: string;
    is_initial: boolean;
    is_final: boolean;
    color: string;
}

interface TransitionDef {
    from: string;
    to: string;
    label: string;
    conditions: Array<{ type: string; value: string }>;
    actions: Array<{ type: string; config: Record<string, string> }>;
}

const props = defineProps<{
    states: StateDef[];
    transitions: TransitionDef[];
}>();

const emit = defineEmits<{
    'update:states': [value: StateDef[]];
    'update:transitions': [value: TransitionDef[]];
}>();

const newStateName = ref('');
const newTransFrom = ref('');
const newTransTo = ref('');
const newTransLabel = ref('');

const stateNames = computed(() => props.states.map((s) => s.name));

function addState() {
    if (!newStateName.value.trim()) return;
    const name = newStateName.value.trim().toLowerCase().replace(/\s+/g, '_');
    const states = [
        ...props.states,
        {
            name,
            label: newStateName.value.trim(),
            is_initial: props.states.length === 0,
            is_final: false,
            color: '#6366f1',
        },
    ];
    emit('update:states', states);
    newStateName.value = '';
}

function removeState(index: number) {
    const removed = props.states[index].name;
    const states = props.states.filter((_, i) => i !== index);
    const transitions = props.transitions.filter((t) => t.from !== removed && t.to !== removed);
    emit('update:states', states);
    emit('update:transitions', transitions);
}

function toggleInitial(index: number) {
    const states = props.states.map((s, i) => ({
        ...s,
        is_initial: i === index ? !s.is_initial : false,
    }));
    emit('update:states', states);
}

function toggleFinal(index: number) {
    const states = [...props.states];
    states[index] = { ...states[index], is_final: !states[index].is_final };
    emit('update:states', states);
}

function addTransition() {
    if (!newTransFrom.value || !newTransTo.value || !newTransLabel.value.trim()) return;
    const transitions = [
        ...props.transitions,
        {
            from: newTransFrom.value,
            to: newTransTo.value,
            label: newTransLabel.value.trim(),
            conditions: [],
            actions: [],
        },
    ];
    emit('update:transitions', transitions);
    newTransFrom.value = '';
    newTransTo.value = '';
    newTransLabel.value = '';
}

function removeTransition(index: number) {
    const transitions = props.transitions.filter((_, i) => i !== index);
    emit('update:transitions', transitions);
}
</script>

<template>
  <div class="space-y-6">
    <div>
      <h3 class="mb-3 text-sm font-semibold text-gray-300">
        States
      </h3>
      <div class="space-y-2">
        <div
          v-for="(state, idx) in states"
          :key="state.name"
          class="flex items-center gap-3 rounded border border-gray-700 bg-gray-800 px-3 py-2"
        >
          <span class="text-sm text-white">{{ state.label }}</span>
          <span class="text-xs text-gray-500">({{ state.name }})</span>
          <div class="ml-auto flex gap-2">
            <button
              type="button"
              class="rounded px-2 py-0.5 text-xs"
              :class="state.is_initial ? 'bg-blue-900/50 text-blue-300' : 'text-gray-500 hover:text-white'"
              @click="toggleInitial(idx)"
            >
              Start
            </button>
            <button
              type="button"
              class="rounded px-2 py-0.5 text-xs"
              :class="state.is_final ? 'bg-purple-900/50 text-purple-300' : 'text-gray-500 hover:text-white'"
              @click="toggleFinal(idx)"
            >
              End
            </button>
            <button
              type="button"
              class="text-xs text-red-400 hover:text-red-300"
              @click="removeState(idx)"
            >
              Remove
            </button>
          </div>
        </div>
      </div>
      <div class="mt-2 flex gap-2">
        <input
          v-model="newStateName"
          placeholder="State label"
          class="flex-1 rounded border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-white"
          @keydown.enter.prevent="addState"
        >
        <button
          type="button"
          class="rounded bg-gray-700 px-4 py-2 text-sm text-white hover:bg-gray-600"
          @click="addState"
        >
          Add State
        </button>
      </div>
    </div>

    <div>
      <h3 class="mb-3 text-sm font-semibold text-gray-300">
        Transitions
      </h3>
      <div class="space-y-2">
        <div
          v-for="(t, idx) in transitions"
          :key="idx"
          class="flex items-center gap-2 rounded border border-gray-700 bg-gray-800 px-3 py-2 text-sm"
        >
          <span class="text-gray-400">{{ t.from }}</span>
          <span class="text-gray-600">&rarr;</span>
          <span class="text-white">{{ t.to }}</span>
          <span class="ml-2 text-xs text-gray-500">({{ t.label }})</span>
          <button
            type="button"
            class="ml-auto text-xs text-red-400 hover:text-red-300"
            @click="removeTransition(idx)"
          >
            Remove
          </button>
        </div>
      </div>
      <div
        v-if="stateNames.length >= 2"
        class="mt-2 flex gap-2"
      >
        <select
          v-model="newTransFrom"
          class="rounded border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-white"
        >
          <option value="">
            From...
          </option>
          <option
            v-for="name in stateNames"
            :key="name"
            :value="name"
          >
            {{ name }}
          </option>
        </select>
        <select
          v-model="newTransTo"
          class="rounded border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-white"
        >
          <option value="">
            To...
          </option>
          <option
            v-for="name in stateNames"
            :key="name"
            :value="name"
          >
            {{ name }}
          </option>
        </select>
        <input
          v-model="newTransLabel"
          placeholder="Label"
          class="flex-1 rounded border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-white"
          @keydown.enter.prevent="addTransition"
        >
        <button
          type="button"
          class="rounded bg-gray-700 px-4 py-2 text-sm text-white hover:bg-gray-600"
          @click="addTransition"
        >
          Add
        </button>
      </div>
    </div>
  </div>
</template>
