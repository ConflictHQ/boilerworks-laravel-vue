<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import FieldRenderer from './FieldRenderer.vue';

interface FieldDef {
    name: string;
    label: string;
    type: string;
    required?: boolean;
    placeholder?: string;
    default?: string | number | boolean | null;
    options?: Array<{ label: string; value: string }>;
}

const props = defineProps<{
    schema: { fields: FieldDef[] };
    submitUrl: string;
}>();

const fields = computed(() => props.schema.fields || []);

const initialData: Record<string, string | number | boolean | null> = {};
fields.value.forEach((field) => {
    initialData[field.name] = field.default ?? null;
});

const form = useForm({ data: initialData });

function submit() {
    form.post(props.submitUrl);
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="submit">
        <FieldRenderer
            v-for="field in fields"
            :key="field.name"
            :field="field"
            :model-value="form.data[field.name]"
            :error="form.errors[`data.${field.name}`]"
            @update:model-value="form.data[field.name] = $event"
        />
        <button
            type="submit"
            :disabled="form.processing"
            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
        >
            Submit
        </button>
    </form>
</template>
