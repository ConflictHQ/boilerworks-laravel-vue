<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    links: Array<{ url: string | null; label: string; active: boolean }>;
}>();

const visibleLinks = computed(() =>
    props.links.map((link) => ({
        ...link,
        displayLabel: link.label.replace(/&laquo;/g, '\u00AB').replace(/&raquo;/g, '\u00BB'),
    })),
);
</script>

<template>
    <nav v-if="links.length > 3" class="flex items-center justify-center gap-1">
        <template v-for="link in visibleLinks" :key="link.label">
            <Link
                v-if="link.url"
                :href="link.url"
                class="rounded-md px-3 py-1 text-sm"
                :class="
                    link.active
                        ? 'bg-indigo-600 text-white'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white'
                "
            >
                {{ link.displayLabel }}
            </Link>
            <span v-else class="rounded-md px-3 py-1 text-sm text-gray-600">
                {{ link.displayLabel }}
            </span>
        </template>
    </nav>
</template>
