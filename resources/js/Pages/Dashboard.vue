<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="text-2xl font-bold">
            Dashboard
        </h1>

        <p>
            Welcome, {{ page.props.auth.user.name }}!
        </p>
    </AuthenticatedLayout>
</template>