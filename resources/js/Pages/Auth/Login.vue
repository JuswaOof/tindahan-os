<script setup>
    import { useForm } from '@inertiajs/vue3'

    const form = useForm({
        email: '',
        password: '',
    })
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-lg">

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    TindahanOS
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Sign in to your account
                </p>
            </div>

            <form @submit.prevent="form.post('/login')">

                <!-- Email -->
                <div class="mb-5">
                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >

                    <p
                        v-if="form.errors.email"
                        class="mt-1 text-sm text-red-500"
                    >
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Password
                    </label>

                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >

                    <p
                        v-if="form.errors.password"
                        class="mt-1 text-sm text-red-500"
                    >
                        {{ form.errors.password }}
                    </p>
                </div>

                <!-- Login button -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-lg bg-blue-600 px-4 py-2.5 font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    {{ form.processing ? 'Logging in...' : 'Login' }}
                </button>

            </form>
        </div>
    </div>
</template>