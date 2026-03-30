<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps<{
    stats: { items: number; categories: number; users: number };
}>();
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout>
        <h1 class="mb-6 text-2xl font-bold text-white">Dashboard</h1>
        <div class="grid gap-6 sm:grid-cols-3">
            <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
                <p class="text-sm text-gray-400">Items</p>
                <p class="mt-1 text-3xl font-bold text-white">
                    {{ stats.items }}
                </p>
            </div>
            <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
                <p class="text-sm text-gray-400">Categories</p>
                <p class="mt-1 text-3xl font-bold text-white">
                    {{ stats.categories }}
                </p>
            </div>
            <div class="rounded-lg border border-gray-800 bg-gray-900 p-6">
                <p class="text-sm text-gray-400">Users</p>
                <p class="mt-1 text-3xl font-bold text-white">
                    {{ stats.users }}
                </p>
            </div>
        </div>
    </AppLayout>
</template>
