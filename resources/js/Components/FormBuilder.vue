<script setup lang="ts">
import { ref } from 'vue';

interface FieldDef {
    name: string;
    label: string;
    type: string;
    required: boolean;
    placeholder: string;
    options: Array<{ label: string; value: string }>;
}

const props = defineProps<{
    modelValue: { fields: FieldDef[] };
}>();

const emit = defineEmits<{
    'update:modelValue': [value: { fields: FieldDef[] }];
}>();

const fieldTypes = [
    { value: 'text', label: 'Text' },
    { value: 'textarea', label: 'Textarea' },
    { value: 'number', label: 'Number' },
    { value: 'email', label: 'Email' },
    { value: 'select', label: 'Select' },
    { value: 'checkbox', label: 'Checkbox' },
    { value: 'radio', label: 'Radio' },
    { value: 'date', label: 'Date' },
];

const newFieldName = ref('');
const newFieldType = ref('text');

function addField() {
    if (!newFieldName.value.trim()) return;
    const name = newFieldName.value.trim().toLowerCase().replace(/\s+/g, '_');
    const fields = [
        ...props.modelValue.fields,
        {
            name,
            label: newFieldName.value.trim(),
            type: newFieldType.value,
            required: false,
            placeholder: '',
            options: [],
        },
    ];
    emit('update:modelValue', { fields });
    newFieldName.value = '';
    newFieldType.value = 'text';
}

function removeField(index: number) {
    const fields = props.modelValue.fields.filter((_, i) => i !== index);
    emit('update:modelValue', { fields });
}

function updateField(index: number, key: string, value: unknown) {
    const fields = [...props.modelValue.fields];
    fields[index] = { ...fields[index], [key]: value };
    emit('update:modelValue', { fields });
}

function moveField(index: number, direction: number) {
    const fields = [...props.modelValue.fields];
    const target = index + direction;
    if (target < 0 || target >= fields.length) return;
    [fields[index], fields[target]] = [fields[target], fields[index]];
    emit('update:modelValue', { fields });
}

function addOption(fieldIndex: number) {
    const fields = [...props.modelValue.fields];
    const options = [...(fields[fieldIndex].options || []), { label: '', value: '' }];
    fields[fieldIndex] = { ...fields[fieldIndex], options };
    emit('update:modelValue', { fields });
}

function updateOption(fieldIndex: number, optIndex: number, key: string, value: string) {
    const fields = [...props.modelValue.fields];
    const options = [...fields[fieldIndex].options];
    options[optIndex] = { ...options[optIndex], [key]: value };
    fields[fieldIndex] = { ...fields[fieldIndex], options };
    emit('update:modelValue', { fields });
}

function removeOption(fieldIndex: number, optIndex: number) {
    const fields = [...props.modelValue.fields];
    const options = fields[fieldIndex].options.filter((_, i) => i !== optIndex);
    fields[fieldIndex] = { ...fields[fieldIndex], options };
    emit('update:modelValue', { fields });
}
</script>

<template>
    <div class="space-y-4">
        <div
            v-for="(field, index) in modelValue.fields"
            :key="index"
            class="rounded-lg border border-gray-700 bg-gray-800 p-4"
        >
            <div class="mb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">{{ index + 1 }}.</span>
                    <span class="text-sm font-medium text-white">{{ field.label }}</span>
                    <span class="rounded bg-gray-700 px-1.5 py-0.5 text-xs text-gray-400">{{
                        field.type
                    }}</span>
                </div>
                <div class="flex gap-1">
                    <button
                        type="button"
                        class="rounded px-2 py-1 text-xs text-gray-400 hover:bg-gray-700"
                        @click="moveField(index, -1)"
                    >
                        Up
                    </button>
                    <button
                        type="button"
                        class="rounded px-2 py-1 text-xs text-gray-400 hover:bg-gray-700"
                        @click="moveField(index, 1)"
                    >
                        Down
                    </button>
                    <button
                        type="button"
                        class="rounded px-2 py-1 text-xs text-red-400 hover:bg-red-900/50"
                        @click="removeField(index)"
                    >
                        Remove
                    </button>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-3">
                <div>
                    <label class="mb-1 block text-xs text-gray-400">Label</label>
                    <input
                        :value="field.label"
                        class="w-full rounded border border-gray-600 bg-gray-900 px-2 py-1 text-sm text-white"
                        @input="
                            updateField(index, 'label', ($event.target as HTMLInputElement).value)
                        "
                    />
                </div>
                <div>
                    <label class="mb-1 block text-xs text-gray-400">Name</label>
                    <input
                        :value="field.name"
                        class="w-full rounded border border-gray-600 bg-gray-900 px-2 py-1 text-sm text-white"
                        @input="
                            updateField(index, 'name', ($event.target as HTMLInputElement).value)
                        "
                    />
                </div>
                <div class="flex items-end gap-3">
                    <label class="flex items-center gap-1 text-xs text-gray-400">
                        <input
                            type="checkbox"
                            :checked="field.required"
                            class="rounded border-gray-600 bg-gray-900 text-indigo-500"
                            @change="
                                updateField(
                                    index,
                                    'required',
                                    ($event.target as HTMLInputElement).checked,
                                )
                            "
                        />
                        Required
                    </label>
                </div>
            </div>
            <div v-if="field.type === 'select' || field.type === 'radio'" class="mt-3">
                <label class="mb-1 block text-xs text-gray-400">Options</label>
                <div v-for="(opt, optIdx) in field.options" :key="optIdx" class="mb-1 flex gap-2">
                    <input
                        :value="opt.label"
                        placeholder="Label"
                        class="flex-1 rounded border border-gray-600 bg-gray-900 px-2 py-1 text-sm text-white"
                        @input="
                            updateOption(
                                index,
                                optIdx,
                                'label',
                                ($event.target as HTMLInputElement).value,
                            )
                        "
                    />
                    <input
                        :value="opt.value"
                        placeholder="Value"
                        class="flex-1 rounded border border-gray-600 bg-gray-900 px-2 py-1 text-sm text-white"
                        @input="
                            updateOption(
                                index,
                                optIdx,
                                'value',
                                ($event.target as HTMLInputElement).value,
                            )
                        "
                    />
                    <button
                        type="button"
                        class="text-xs text-red-400"
                        @click="removeOption(index, optIdx)"
                    >
                        x
                    </button>
                </div>
                <button
                    type="button"
                    class="mt-1 text-xs text-indigo-400 hover:text-indigo-300"
                    @click="addOption(index)"
                >
                    + Add Option
                </button>
            </div>
        </div>

        <div class="flex gap-2">
            <input
                v-model="newFieldName"
                placeholder="Field label"
                class="flex-1 rounded border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-white"
                @keydown.enter.prevent="addField"
            />
            <select
                v-model="newFieldType"
                class="rounded border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-white"
            >
                <option v-for="ft in fieldTypes" :key="ft.value" :value="ft.value">
                    {{ ft.label }}
                </option>
            </select>
            <button
                type="button"
                class="rounded bg-gray-700 px-4 py-2 text-sm text-white hover:bg-gray-600"
                @click="addField"
            >
                Add Field
            </button>
        </div>
    </div>
</template>
