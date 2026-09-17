<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

    defineProps({
        products: Array,
    });
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="text-2xl font-bold">
            Products
        </h1>
    {{ products }}
    </AuthenticatedLayout>
</template>