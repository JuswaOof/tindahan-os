<script setup>
import { router, usePage } from '@inertiajs/vue3'
import NavigationLink from '@/Components/NavigationLink.vue'

const page = usePage()
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 w-64 border-r border-gray-200 bg-white">
            <!-- Logo -->
            <div class="flex h-16 items-center border-b border-gray-200 px-6">
                <h1 class="text-xl font-bold text-gray-900">
                    TindahanOS
                </h1>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1 p-4">
                <NavigationLink href="/dashboard">
                    Dashboard
                </NavigationLink>

                <NavigationLink href="/categories">
                    Categories
                </NavigationLink>

                <NavigationLink href="/products">
                    Products
                </NavigationLink>
            </nav>
        </aside>

        <!-- Main area -->
        <div class="ml-64">
            <!-- Topbar -->
            <header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-6">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ page.url === '/dashboard' ? 'Dashboard' : 'Categories' }}
                </h2>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        {{ page.props.auth.user.name }}
                    </span>

                    <button
                        type="button"
                        class="text-sm font-medium text-gray-600 hover:text-gray-900"
                        @click="router.post('/logout')"
                    >
                        Logout
                    </button>
                </div>
            </header>

            <!-- Page content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>