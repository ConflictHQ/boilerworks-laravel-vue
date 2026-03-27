<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    permission: string;
}>();

const page = usePage();
const can = computed(() => {
    const permissions = (page.props.auth as { permissions: string[] })?.permissions ?? [];
    return permissions.includes(props.permission);
});
</script>

<template>
  <slot v-if="can" />
</template>
