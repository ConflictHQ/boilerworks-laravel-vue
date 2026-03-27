<script setup lang="ts">
interface FieldDef {
    name: string;
    label: string;
    type: string;
    required?: boolean;
    placeholder?: string;
    options?: Array<{ label: string; value: string }>;
}

defineProps<{
    field: FieldDef;
    modelValue: string | number | boolean | null;
    error?: string;
}>();

defineEmits<{
    'update:modelValue': [value: string | number | boolean | null];
}>();
</script>

<template>
  <div>
    <label
      :for="field.name"
      class="mb-1 block text-sm font-medium text-gray-300"
    >
      {{ field.label }}
      <span
        v-if="field.required"
        class="text-red-400"
      >*</span>
    </label>

    <input
      v-if="field.type === 'text' || field.type === 'email'"
      :id="field.name"
      :type="field.type"
      :value="modelValue"
      :required="field.required"
      :placeholder="field.placeholder"
      class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >

    <input
      v-else-if="field.type === 'number'"
      :id="field.name"
      type="number"
      :value="modelValue"
      :required="field.required"
      :placeholder="field.placeholder"
      class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >

    <input
      v-else-if="field.type === 'date'"
      :id="field.name"
      type="date"
      :value="modelValue"
      :required="field.required"
      class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >

    <textarea
      v-else-if="field.type === 'textarea'"
      :id="field.name"
      rows="3"
      :value="modelValue as string"
      :required="field.required"
      :placeholder="field.placeholder"
      class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
      @input="$emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)"
    />

    <select
      v-else-if="field.type === 'select'"
      :id="field.name"
      :value="modelValue"
      :required="field.required"
      class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
      @change="$emit('update:modelValue', ($event.target as HTMLSelectElement).value)"
    >
      <option value="">
        Select...
      </option>
      <option
        v-for="opt in field.options"
        :key="opt.value"
        :value="opt.value"
      >
        {{ opt.label }}
      </option>
    </select>

    <div
      v-else-if="field.type === 'radio'"
      class="space-y-2"
    >
      <label
        v-for="opt in field.options"
        :key="opt.value"
        class="flex items-center gap-2 text-sm text-gray-300"
      >
        <input
          type="radio"
          :name="field.name"
          :value="opt.value"
          :checked="modelValue === opt.value"
          class="border-gray-600 bg-gray-800 text-indigo-500"
          @change="$emit('update:modelValue', opt.value)"
        >
        {{ opt.label }}
      </label>
    </div>

    <label
      v-else-if="field.type === 'checkbox'"
      class="flex items-center gap-2 text-sm text-gray-300"
    >
      <input
        type="checkbox"
        :checked="!!modelValue"
        class="rounded border-gray-600 bg-gray-800 text-indigo-500"
        @change="$emit('update:modelValue', ($event.target as HTMLInputElement).checked)"
      >
      {{ field.label }}
    </label>

    <p
      v-if="error"
      class="mt-1 text-sm text-red-400"
    >
      {{ error }}
    </p>
  </div>
</template>
