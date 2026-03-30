<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <Head title="Register" />
    <div class="flex min-h-screen items-center justify-center bg-gray-950 px-4">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <img src="/images/logo-dark.svg" alt="Boilerworks" class="mx-auto mb-4 h-10" />
                <h1 class="text-2xl font-bold text-white">Create account</h1>
            </div>

            <form
                class="space-y-6 rounded-lg border border-gray-800 bg-gray-900 p-8"
                @submit.prevent="submit"
            >
                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-gray-300">
                        Name
                    </label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        autocomplete="name"
                        required
                        class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-400">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-300">
                        Email
                    </label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        required
                        class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-400">
                        {{ form.errors.email }}
                    </p>
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-gray-300">
                        Password
                    </label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    />
                    <p v-if="form.errors.password" class="mt-1 text-sm text-red-400">
                        {{ form.errors.password }}
                    </p>
                </div>

                <div>
                    <label
                        for="password_confirmation"
                        class="mb-1 block text-sm font-medium text-gray-300"
                    >
                        Confirm password
                    </label>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    />
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 disabled:opacity-50"
                >
                    Create account
                </button>

                <p class="text-center text-sm text-gray-400">
                    Already have an account?
                    <Link href="/login" class="text-indigo-400 hover:text-indigo-300">
                        Sign in
                    </Link>
                </p>
            </form>
        </div>
    </div>
</template>
